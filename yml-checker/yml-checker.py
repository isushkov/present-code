#!/usr/bin/env python3

import argparse
import yaml


class Service(object):
    name = ''
    data = {}
    network_mode = ''
    environment = []
    queues = []

    def __init__(self, name, data):
        self.name = name
        self.data = data
        self.network_mode = self.get_value('network_mode')
        self.environment = self.get_value('environment')
        self.queues = self.get_queues()

    def has_param(self, search_param):
        for param_name in self.data:
            if param_name == search_param:
                return True
        return False

    def get_value(self, param_name):
        if self.has_param(param_name):
            return self.data[param_name]

    def get_queues(self):
        queues = []
        if self.has_param('environment'):
            for envar in self.environment:
                if 'QUEUE' in envar: 
                    queues.append(envar)
        return queues

def createParser ():
    parser = argparse.ArgumentParser(description='Check docker-compose yml config')
    parser.add_argument('filename', help='путь к docker-compose.yml файлу')
    parser.add_argument('-t', '--type', type=str, default='network',
        help='указать тип проверки: network (default) or queues or all')
    parser.add_argument('-o', '--output', type=str, default='short',
        help='указать тип вывода: short (default) or user')

    return parser

def output_validate():
    if not namespace.type == 'network' and not namespace.type == 'queues' and not namespace.type == 'all':
        print('please select correct --type')
        exit()
    if not namespace.output == 'short' and not namespace.output == 'user':
        print('please select correct --output')
        exit()

def output_network_mode():
    if namespace.type == 'network' or namespace.type == 'all':
        if namespace.output == 'user':
            output_network_mode_user()
        else:
            output_network_mode_short()

def output_network_mode_user():
    print('=== SEARCH NETWORK_MODE param ===')
    print('=== filename: ' + namespace.filename + ' ===')
    for service in services:
        print('service name: ' + service.name)
        print('has_param "network_mode"?: ' + str(service.has_param('network_mode')))
        print('value network_mode: ' + str(service.network_mode))
    print()

def output_network_mode_short():
    has_network_param = True
    for service in services:
        if not service.has_param('network_mode'):
            has_network_param = False
            break
    if has_network_param:
        print(1)
    else:
        print(0)

def output_queues_list():
    if namespace.type == 'queues' or namespace.type == 'all':
        if namespace.output == 'user':
            output_queues_list_user()
        else:
            output_queues_list_short()

def output_queues_list_user():
    print('=== SEARCH QUEUES ===')
    print('=== filename: ' + namespace.filename + ' ===')
    for service in services:
        print('service name: ' + service.name)
        print('queues: ' + str(service.queues))
    print()

def output_queues_list_short():
    has_queues = True
    for service in services:
        if not bool(service.queues):
            has_queues = False
            break
    if has_queues:
        print(1)
    else:
        print(0)

if __name__ == '__main__':
    # prepare args
    parser = createParser()
    namespace = parser.parse_args()
    output_validate()
    # get docker-compose.yml content:
    with open(namespace.filename) as f:
        data = yaml.load(f, Loader=yaml.FullLoader)
    # calculate services
    services = []
    for service_name in data['services']:
        service = Service(service_name, data['services'][service_name])
        services.append(service)
    # output
    output_network_mode()
    output_queues_list()
