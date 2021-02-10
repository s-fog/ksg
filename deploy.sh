#!/bin/bash
ssh -i "~/.ssh/ksg_rsa" ubuntu@46.229.214.117 <<'ENDSSH'
cd /var/www/ksg.ru
git pull
docker-compose run --rm ksg_php ./deploy_php.sh
ENDSSH
