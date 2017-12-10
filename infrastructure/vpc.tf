resource "aws_vpc" "qa" {
  cidr_block = "10.101.0.0/16"

  tags {
    Name      = "FacetQaVpc"
    CreatedBy = "Terraform"
    Contact   = "${var.contact_info}"
  }
}
