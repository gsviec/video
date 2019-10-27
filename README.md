## Gsviec.com

Screencast for the Vietnamese developers [gsviec.com](https://gsviec.com)

## Install the development guide:

### 1. Prerequisites:
- Docker
- Docker-compose
- NodeJS and Npm

Step 1: Clone repo:

```
git clone git@github.com:gsviec/video.git

````


Step 2: Start the development environment

```
docker-compose up -d

````

Then waiting a moment to download on image.
After Docker compose install success full, now we can install Gsviec PHP depedencies by the command below.


Step 3: Install dependencies

```
docker-compose exec php php composer.phar install
````


### 2. Compile Frontend Assets.

We use [Grunt](https://gruntjs.com/installing-grunt) for compiling frontend assets.

**Notice**:
Only use Grunt for compile when you deploy production.


Please check the Node and npm version:

```bash
➜  node -v
v8.10.0
➜  npm -v
3.5.2

```
Install _grunt_ and and some dev plugins by the command:

```bash
npm i -D

```

Notice:  

If you have problem when install npm, please check permission of
**node_modules** repository.

After that just running following:

```
grunt

```

### 3. Deploy

If you want to deploy via ansible

```
ansible-playbook -i hosts/production/inventory deploy.yml

```

### 4. Sending newsletter

To test preview before send to all users:

```
php cli SendDigest
```

When the template is ok,you can runing agian a command above with option

```
php cli SendDigest main send
```

### 5. License

The MIT License (MIT). 
