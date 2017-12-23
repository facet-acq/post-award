resource "aws_security_group" "public_load_balancer" {
  name        = "PublicAlb"
  description = "Allow web traffic from users to interact with the application servers"
  vpc_id      = "${aws_vpc.qa.id}"

  tags {
    Name      = "PublicAlb"
    CreatedBy = "Terraform"
    Contact   = "${var.contact_info}"
  }
}

resource "aws_security_group" "bastion" {
  name        = "BastionAccess"
  description = "Provide remote administration to interact with servers via hardened bastion jumpbox"
  vpc_id      = "${aws_vpc.qa.id}"

  tags {
    Name      = "BastionAccess"
    CreatedBy = "Terraform"
    Contact   = "${var.contact_info}"
  }
}

resource "aws_security_group" "cache" {
  name        = "ApplicationCache"
  description = "Access protection for the caching cluster"
  vpc_id      = "${aws_vpc.qa.id}"

  tags {
    Name      = "ApplicationCache"
    CreatedBy = "Terraform"
    Contact   = "${var.contact_info}"
  }
}

resource "aws_security_group" "database" {
  name        = "ApplicationDatabase"
  description = "Access protection for the database cluster"
  vpc_id      = "${aws_vpc.qa.id}"

  tags {
    Name      = "ApplicationDatabase"
    CreatedBy = "Terraform"
    Contact   = "${var.contact_info}"
  }
}

resource "aws_security_group" "web_application" {
  name        = "ApplicationServer"
  description = "Access protection for the application compute processing resources"
  vpc_id      = "${aws_vpc.qa.id}"

  tags {
    Name      = "ApplicationServer"
    CreatedBy = "Terraform"
    Contact   = "${var.contact_info}"
  }
}

resource "aws_security_group" "trading_partner_dropzone" {
  name        = "Dropzone"
  description = "Access protection for EDI dropoff"
  vpc_id      = "${aws_vpc.qa.id}"

  tags {
    Name      = "Dropzone"
    CreatedBy = "Terraform"
    Contact   = "${var.contact_info}"
  }
}

resource "aws_security_group" "nat_instance" {
  name        = "NatInstance"
  description = "Passthrough to access internet resources from private subnets"
  vpc_id      = "${aws_vpc.qa.id}"

  tags {
    Name      = "NatInstance"
    CreatedBy = "Terraform"
    Contact   = "${var.contact_info}"
  }
}
