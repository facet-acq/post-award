resource "aws_vpc" "edi_van_nova" {
  cidr_block = "10.102.0.0/16"

  tags {
    Name      = "EdiVanNova"
    CreatedBy = "Terraform"
    Contact   = "${var.contact_info}"
    Supports  = "FACET"
  }
}
