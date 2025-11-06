pipeline {
    agent {
        docker {
            image 'php:8.2-cli'
            args '-v $PWD:/app -w /app'
        }
    }

    stages {
        stage('Checkout') {
            steps {
                git branch: 'main', url: 'https://github.com/OhKangWoo/containers08.git'
            }
        }

        stage('Install Composer & Dependencies') {
            steps {
                sh '''
                    apt-get update && apt-get install -y unzip git sqlite3 curl
                    curl -sS https://getcomposer.org/installer | php
                    php composer.phar install --no-interaction
                '''
            }
        }

        stage('Run Tests') {
            steps {
                sh '''
                    mkdir -p test-results
                    ./vendor/bin/phpunit --testdox --log-junit test-results/junit.xml || true
                '''
            }
        }

        stage('Publish Test Results') {
            steps {
                junit 'test-results/junit.xml'
            }
        }
    }

    post {
        always {
            echo '🏁 Pipeline finalizat.'
        }
        success {
            echo '✅ Testele au trecut!'
        }
        failure {
            echo '❌ Unele etape au eșuat — verifică logurile!'
        }
    }
}
