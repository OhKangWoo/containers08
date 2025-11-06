pipeline {
    agent {
        label 'php-agent'
    }
    
    stages {        
        stage('Checkout') {
            steps {
                echo 'Checking out source code from GitHub...'
                checkout scm
            }
        }
        
        stage('Setup Database') {
            steps {
                echo 'Setting up SQLite database...'
                sh '''
                    cd site
                    sqlite3 data.db < schema.sql
                    echo "Database created successfully"
                    ls -lh data.db
                '''
            }
        }
        
        stage('Verify Environment') {
            steps {
                echo 'Verifying PHP and SQLite installation...'
                sh '''
                    echo "PHP Version:"
                    php --version
                    echo ""
                    echo "SQLite3 Extension:"
                    php -m | grep sqlite3
                    echo ""
                    echo "SQLite Version:"
                    sqlite3 --version
                '''
            }
        }
        
        stage('Run Unit Tests') {
            steps {
                echo 'Running unit tests with custom test framework...'
                sh '''
                    cd tests
                    php tests.php
                '''
            }
        }
        
        stage('Test Summary') {
            steps {
                echo 'All tests completed successfully!'
                sh '''
                    echo "✓ Database class tests passed"
                    echo "✓ Page class tests passed"
                    echo "✓ All unit tests executed successfully"
                '''
            }
        }
    }
    
    post {
        always {
            echo 'Pipeline execution completed.'
            echo 'Cleaning up workspace...'
            cleanWs()
        }
        success {
            echo '=========================================='
            echo 'SUCCESS: All stages completed successfully!'
            echo 'All unit tests passed.'
            echo '=========================================='
        }
        failure {
            echo '=========================================='
            echo 'FAILURE: Pipeline encountered errors.'
            echo 'Please check the logs above for details.'
            echo '=========================================='
        }
    }
}
