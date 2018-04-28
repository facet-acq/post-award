resource "aws_subnet" "edi_nova_main" {
  vpc_id            = "${aws_vpc.edi_van_nova.id}"
  cidr_block        = "10.102.1.0/24"
  availability_zone = "us-east-1f"

  tags {
    Name      = "Edi Nova Main"
    CreatedBy = "Terraform"
    Contact   = "${var.contact_info}"
    Supports  = "FACET"
  }
}

resource "aws_subnet" "edi_nova_backup" {
  vpc_id            = "${aws_vpc.edi_van_nova.id}"
  cidr_block        = "10.102.2.0/24"
  availability_zone = "us-east-1c"

  tags {
    Name      = "Edi Nova Backup"
    CreatedBy = "Terraform"
    Contact   = "${var.contact_info}"
    Supports  = "FACET"
  }
}
