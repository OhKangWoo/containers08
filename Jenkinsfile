pipeline {
    agent any

    stages {
        stage('Checkout') {
            steps {
                git 'https://github.com/OhKangWoo/containers08.git'
            }
        }

        stage('Install PHP & Composer') {
            steps {
                sh '''
                    apt-get update && apt-get install -y php php-cli php-mbstring unzip git sqlite3 curl
                    curl -sS https://getcomposer.org/installer | php
                    php composer.phar install
                '''
            }
        }

        stage('Run Tests') {
            steps {
                sh '''
                    if [ -f ./vendor/bin/phpunit ]; then
                        ./vendor/bin/phpunit --testdox
                    else
                        php composer.phar require --dev phpunit/phpunit
                        ./vendor/bin/phpunit --testdox
                    fi
                '''
            }
        }
    }

    post {
        success {
            echo '✅ Testele au trecut!'
        }
        failure {
            echo '❌ Testele au eșuat!'
        }
    }
}
