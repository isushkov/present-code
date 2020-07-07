usage: yml-checker.py [-h] [-t TYPE] [-o OUTPUT] filename

Check docker-compose yml config

positional arguments:

  filename
  путь к docker-compose.yml файлу

optional arguments:

  -h, --help                  
  show this help message and exit
  
  -t TYPE, --type TYPE        
  указать тип проверки: network (default) or queues or all
  
  -o OUTPUT, --output OUTPUT  
  указать тип вывода: short (default) or user
