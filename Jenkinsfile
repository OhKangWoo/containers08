pipeline {
    agent any

    stages {
        stage('Checkout') {
            steps {
                git branch: 'main', url: 'https://github.com/OhKangWoo/containers08.git'
            }
        }

        stage('Install Dependencies') {
            steps {
                sh '''
                    echo "Instalare dependințe PHP..."
                    composer install || true
                '''
            }
        }

        stage('Run Tests') {
            steps {
                sh '''
                    echo "Rulare teste unitare..."
                    if [ -f ./vendor/bin/phpunit ]; then
                        ./vendor/bin/phpunit --testdox
                    else
                        echo "⚠️ PHPUnit nu este instalat. Rulează testele manual sau instalează-l cu Composer."
                        composer require --dev phpunit/phpunit
                        ./vendor/bin/phpunit --testdox
                    fi
                '''
            }
        }
    }

    post {
        always {
            echo "Pipeline încheiat."
        }
        success {
            echo "✅ Toate testele au trecut cu succes!"
        }
        failure {
            echo "❌ Testele au eșuat!"
        }
    }
}
