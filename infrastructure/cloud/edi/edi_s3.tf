resource "aws_s3_bucket" "edi_storage_nova" {
  bucket = "facet-post-award-edi-nova-dev"
  acl    = "private"

  region = "us-east-1"

  server_side_encryption_configuration {
    rule {
      apply_server_side_encryption_by_default {
        sse_algorithm = "AES256"
      }
    }
  }

  logging {
    target_bucket = "${aws_s3_bucket.edi_log.id}"
    target_prefix = "nova/"
  }

  tags {
    Enviornment = "dev"
    Supports    = "FACET"
    CreatedBy   = "Terraform"
    Contact     = "${var.contact_info}"
  }
}

resource "aws_s3_bucket" "edi_storage_midwest" {
  bucket = "facet-post-award-edi-midwest-dev"
  acl    = "private"

  region = "us-east-2"

  server_side_encryption_configuration {
    rule {
      apply_server_side_encryption_by_default {
        sse_algorithm = "AES256"
      }
    }
  }

  logging {
    target_bucket = "${aws_s3_bucket.edi_log.id}"
    target_prefix = "midwest/"
  }

  tags {
    Enviornment = "dev"
    Supports    = "FACET"
    CreatedBy   = "Terraform"
    Contact     = "${var.contact_info}"
  }
}

resource "aws_s3_bucket" "edi_log" {
  bucket = "facet-post-award-edi-log-dev"
  acl    = "log-delivery-write"

  region = "us-east-1"

  server_side_encryption_configuration {
    rule {
      apply_server_side_encryption_by_default {
        sse_algorithm = "AES256"
      }
    }
  }

  tags {
    Enviornment = "dev"
    Supports    = "FACET"
    CreatedBy   = "Terraform"
    Contact     = "${var.contact_info}"
  }
}
