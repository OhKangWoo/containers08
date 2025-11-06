pipeline {
    agent {
        docker {
            image 'php:8.2-cli'   // agentul va rula în containerul oficial PHP
            args '-v $PWD:/app -w /app'
        }
    }

    stages {
        stage('Checkout') {
            steps {
                git 'https://github.com/OhKangWoo/containers08.git'
            }
        }

        stage('Install Composer & Dependencies') {
            steps {
                sh '''
                    apt-get update && apt-get install -y unzip git sqlite3
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
        always {
            echo 'Pipeline finalizat.'
        }
        success {
            echo '✅ Toate testele au trecut cu succes!'
        }
        failure {
            echo '❌ Testele au eșuat!'
        }
    }
}
