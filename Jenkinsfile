pipeline {
    agent any

    environment {
        COMPOSER_HOME = "${WORKSPACE}/.composer"
    }

    stages {

        stage('Checkout') {
            steps {
                echo '📦 Checkout cod din GitHub...'
                git branch: 'main', url: 'https://github.com/OhKangWoo/containers08.git'
            }
        }

        stage('Install PHP & Composer') {
            steps {
                echo '⚙️ Instalare PHP, SQLite și Composer...'
                sh '''
                    apt-get update && apt-get install -y php php-cli php-mbstring unzip git sqlite3 curl
                    curl -sS https://getcomposer.org/installer | php
                    php composer.phar install --no-interaction
                '''
            }
        }

        stage('Run Tests') {
            steps {
                echo '🧪 Rulare teste unitare...'
                sh '''
                    if [ ! -f ./vendor/bin/phpunit ]; then
                        php composer.phar require --dev phpunit/phpunit
                    fi

                    mkdir -p test-results
                    ./vendor/bin/phpunit --testdox --log-junit test-results/junit.xml || true
                '''
            }
        }

        stage('Publish Test Results') {
            steps {
                echo '📊 Publicare rapoarte de testare în Jenkins...'
                junit 'test-results/junit.xml'
            }
        }
    }

    post {
        always {
            echo '🏁 Pipeline finalizat.'
        }
        success {
            echo '✅ Toate etapele au trecut cu succes!'
        }
        failure {
            echo '❌ Unele etape au eșuat — verifică logurile Jenkins.'
        }
    }
}
