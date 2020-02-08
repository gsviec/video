## Gsviec.com

Screencasts for the Vietnamese developers.
To see how it work just goto [gsviec.com](https://gsviec.com)

## Install:

### Requirements:
- Docker
- Docker-compose


Step 1: Clone repo:

```
git clone git@github.com:gsviec/video.git

````


Step 2: Up

```
docker-compose up -d

````

Then waiting a moment to download on image, but gsviec video need library php so that you also need running command below'

Step 3: Install dependencies

```
docker-compose exec php php composer.phar install
````


### Compile Assets

We use [Grunt](https://gruntjs.com/installing-grunt) for compiling frontend assets.


Install grunt and plugin it via command below

```bash
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
### Sending newsletter

To test preview before send to all users:

```
php cli SendDigest
```

When the template is ok,you can runing agian a command above with option

```
php cli SendDigest main send
```

