pipeline {
    agent any

    stages {




        stage('Build') {
            steps {
                echo 'Building'
                sh 'composer install'
            }
        }
        stage('Test') {
            steps {
                echo 'Testing...'
                // Add your test steps here
            }
        }
        stage('Deploy') {
            steps {
                echo 'Deploying...'
                // Add your deployment steps here
            }
        }
    }

    post {
        success {
            echo 'Pipeline succeeded!'
            // Add any actions you want to take on success
        }
        failure {
            echo 'Pipeline failed!'
            // Add any actions you want to take on failure
        }
        always {
            echo 'Pipeline completed!'
            // Add any actions you want to take always, regardless of result
        }
    }
}
