#!/bin/bash
ssh -i "~/.ssh/yandex_cloud_compute_cloud_rsa" ubuntu@178.154.249.173 <<'ENDSSH'
cd /var/usync.pro
git pull origin master
sudo systemctl restart usync-horizon.service
cp template.env.prod .env
docker-compose run --rm usync_php ./deploy_php.sh
echo 'Успешно';
ENDSSH
