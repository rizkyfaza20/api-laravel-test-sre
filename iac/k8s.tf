resource "kubernetes_namespace" "k8s-sample-tf" {
  metadata {
    name = "k8s-sample-tf"
  }
}

resource "kubernetes_deployment" "k8s-sample-deployment" {
    metadata {
      name = "k8s-sample-tf"
      labels = {
        env = "dev"
      }
      namespace = "k8s-sample-tf"
    }
    spec {
      replicas = 3

    selector {
      match_labels = {
        env = "dev"
      }
    }

    template {
      metadata {
        labels = {
          env = "dev"
        }
      }
      spec {
        container {
          image = "mrfzy00/crud_laravel_api-sre-test-app:v0.1"
          name = "apps-k8s-test"

          resources {
            limits = {
              cpu = "0.5"
              memory = "512Mi"
            }
            requests = {
              cpu = "250m"
              memory = "50Mi"
            }
          }
        }
      }
    }
  }
}

resource "kubernetes_service" "k8s-sample-service-tf" {
   metadata {
     name = "k8s-sample-service-tf"
     namespace = kubernetes_namespace.k8s-sample-tf.metadata.0.name
   }
   spec {
     selector = {
       env = kubernetes_deployment.k8s-sample-deployment.metadata.0.labels.env
     }
     port {
       protocol = "TCP"
       port = "8000"
     }
   }
   
}