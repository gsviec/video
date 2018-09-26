### Gsviec.com

Gsviec is the  simpple clone youtube channel for you. To see how it work just goto [gsviec.com](https://gsviec.com)

### Setup environment to devel

First you need install docker and docker composer, after that just running the command below:

```
docker-compose up -d

````


### Compile Assets

First you need install grunt and plugin it via command below

```
npm install -g grunt-cli
npm install grunt --save-dev
npm install grunt-bump
npm install grunt-contrib-uglify
npm install grunt-contrib-cssmin
npm install grunt-contrib-concat

```

After that just running fowllowing:

```
grunt

```

### Deploy

If you want to deploy via ansible

```
ansible-playbook -i hosts/production/inventory deploy.yml

```
