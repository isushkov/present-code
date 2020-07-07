#!/bin/bash
# Check run as root
source /.dotfiles-sync/hooks/vars.sh
if [ "$(whoami)" != 'root' ]; then
    echo "${R} PLEASE RUN AS ROOT${RES}"
    kill -SIGUSR1 `ps --pid $$ -oppid=`; exit
else
    echo -n "${G}>>> RUN AS ${Y}"; whoami; echo -n "${RES}"
    echo -n "${G}-------------------${RES}"
fi
