#!/usr/bin/python
# -*- coding: UTF-8 -*-
import sys
import argparse
from colorama import Fore, Back, Style


def createParser ():
    parser = argparse.ArgumentParser()
    parser.add_argument ('docker_compose_yml', nargs='?')

    return parser

class Content(object):
    orig = ''
    lines = ''
    lines_list = []
    end_line_num = 0
    count_spaces_container_block = 0
    start_containers_lines_num = []
    search_param = 'network_mode'

    def __init__(self, file_read):
        self.orig = file_read
        self.lines = self.get_lines()
        self.lines_list = self.get_lines_list()
        self.end_line_num = len(self.lines)
        self.count_spaces_container_block = self.get_count_spaces_from_containers_block()
        self.start_containers_lines_num = self.get_list_start_containers()

    def get_lines(self):
        lines = self.orig.split("\n")
        lines = self.remove_all_empty_lines(lines)
        lines = self.remove_comments(lines)
        lines = self.replace_tabs(lines)
        lines = self.delete_space_end_line(lines)

        return lines

    def get_lines_list(self):
        lines_list = []
        for num, line in enumerate(self.lines, 1):
            new_line = {
                'num': num,
                'value': line,
                'count_spaces': self.get_count_spaces_from_line(line)
            }
            lines_list.append(new_line)

        return lines_list 

    def remove_all_empty_lines(self, lines_list):
        new_lines = []
        for line in lines_list:
            if not all(x.isalpha() and not x.isspace() for x in line):
                new_lines.append(line)

        return new_lines

    def remove_comments(self, lines_list):
        new_lines = []
        for line in lines_list:
            tmp_line = line.replace("\t", "").replace(" ", "")
            if len(tmp_line) > 0:
                if not tmp_line[0] == '#' and len(tmp_line) > 0:
                    new_lines.append(line)

        return new_lines

    def replace_tabs(self, lines_list):
        new_lines = []
        for line in lines_list:
            new_lines.append(line.replace("\t", "    "))

        return new_lines

    def delete_space_end_line(self, lines_list):
        new_lines = []
        for line in lines_list:
            new_lines.append(line.rstrip())

        return new_lines

    def get_count_spaces_from_containers_block(self):
        start_containers_block = 0
        for line in self.lines_list:
            if not start_containers_block == 1:
                if 'services' in line['value']: 
                    start_containers_block = 1
                    continue
            else:
                return self.get_count_spaces_from_line(line['value'])

    def get_count_spaces_from_line(self, line):
        count_spaces = 0
        for symbol in line:
            if symbol == ' ':
                count_spaces += 1
            else:
                break
        return count_spaces

    def get_list_start_containers(self):
        start_containers_lines_num = []
        for line in self.lines_list:
            if line['count_spaces'] == self.count_spaces_container_block:
                start_containers_lines_num.append(line['num'])

        return start_containers_lines_num

# container = Countainer(content.lines_list, content.start_containers_lines_num, content.end_line_num, line)
class Container(object):
    name = ''
    start_line_num = 0
    end_line_num = 0
    lines = ''
    lines_list = []

    def __init__(self, content_lines, content_start_containers_list_num, content_end_line_num, start_line):
        self.start_line_num = start_line['num']
        self.name = start_line['value'].replace(' ', '').replace(':', '')
        self.end_line_num = self.get_end_line_num(content_start_containers_list_num, content_end_line_num)
        self.lines_list = self.get_lines_list(content_lines)
        self.lines = self.get_lines()

    def get_end_line_num(self, content_start_containers_list_num, content_end_line_num):
        for container_start_line in content_start_containers_list_num:
            if container_start_line > self.start_line_num:
                end_line_num = container_start_line - 1 
                break
        # if this is last container
        else:
            end_line_num = content_end_line_num

        return end_line_num

    def get_lines_list(self, content_lines):
        lines_list = []
        for content_line in content_lines: 
            if int(content_line['num']) >= int(self.start_line_num) and int(content_line['num']) <= int(self.end_line_num):
                lines_list.append(content_line)

        return lines_list

    def get_lines(self):
        lines = ''
        for line in self.lines_list: 
            lines += line['value']
            lines += '\n'

        return lines

    def has_network_param(self):
        for line in self.lines_list:
            if content.search_param in line['value']:
                return True
        return False

if __name__ == '__main__':
    # get docker-compose.yml file:
    parser = createParser()
    namespace = parser.parse_args()
    if not namespace.docker_compose_yml:
        print ("docker-compose.yml not set")
        exit()

    # get docker-compose.yml content:
    f = open(namespace.docker_compose_yml, 'r')
    file_read = f.read()
    f.close()
    # create content object
    content = Content(file_read)

    # get containers objects
    containers = []
    for line in content.lines_list:
        if int(line['count_spaces']) == content.count_spaces_container_block:
            # this start container
            container = Container(content.lines_list, content.start_containers_lines_num, content.end_line_num, line)
            containers.append(container)

    # check config network_mode
    # Fore: BLACK, RED, GREEN, YELLOW, BLUE, MAGENTA, CYAN, WHITE, RESET.
    # Back: BLACK, RED, GREEN, YELLOW, BLUE, MAGENTA, CYAN, WHITE, RESET.
    print('search param: ' + Fore.YELLOW + content.search_param + Style.RESET_ALL)
    for container in containers:
        if container.has_network_param():
            print(Fore.CYAN + namespace.docker_compose_yml \
                + Fore.WHITE + ': container name - ' \
                + Fore.GREEN + container.name \
                + Fore.WHITE + ' (param found)' + Style.RESET_ALL) 
        if not container.has_network_param():
            print(Fore.CYAN + namespace.docker_compose_yml \
                + Fore.WHITE + ': container name - ' \
                + Fore.RED + container.name \
                + Fore.WHITE + ' (param not found)' + Style.RESET_ALL)
