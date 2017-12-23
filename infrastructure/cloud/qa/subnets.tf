resource "aws_subnet" "Public1a" {
  vpc_id                  = "${aws_vpc.qa.id}"
  cidr_block              = "10.101.1.0/24"
  availability_zone       = "us-east-1a"
  map_public_ip_on_launch = true

  tags {
    Name      = "Public Facing 1A"
    CreatedBy = "Terraform"
    Contact   = "${var.contact_info}"
  }
}

resource "aws_subnet" "Public1b" {
  vpc_id                  = "${aws_vpc.qa.id}"
  cidr_block              = "10.101.2.0/24"
  availability_zone       = "us-east-1b"
  map_public_ip_on_launch = true

  tags {
    Name      = "Public Facing 1B"
    CreatedBy = "Terraform"
    Contact   = "${var.contact_info}"
  }
}

resource "aws_subnet" "Public1c" {
  vpc_id                  = "${aws_vpc.qa.id}"
  cidr_block              = "10.101.3.0/24"
  availability_zone       = "us-east-1c"
  map_public_ip_on_launch = true

  tags {
    Name      = "Public Facing 1C"
    CreatedBy = "Terraform"
    Contact   = "${var.contact_info}"
  }
}

resource "aws_subnet" "Public1d" {
  vpc_id                  = "${aws_vpc.qa.id}"
  cidr_block              = "10.101.4.0/24"
  availability_zone       = "us-east-1d"
  map_public_ip_on_launch = true

  tags {
    Name      = "Public Facing 1D"
    CreatedBy = "Terraform"
    Contact   = "${var.contact_info}"
  }
}

resource "aws_subnet" "Public1e" {
  vpc_id                  = "${aws_vpc.qa.id}"
  cidr_block              = "10.101.5.0/24"
  availability_zone       = "us-east-1e"
  map_public_ip_on_launch = true

  tags {
    Name      = "Public Facing 1E"
    CreatedBy = "Terraform"
    Contact   = "${var.contact_info}"
  }
}

resource "aws_subnet" "Public1f" {
  vpc_id                  = "${aws_vpc.qa.id}"
  cidr_block              = "10.101.6.0/24"
  availability_zone       = "us-east-1f"
  map_public_ip_on_launch = true

  tags {
    Name      = "Public Facing 1F"
    CreatedBy = "Terraform"
    Contact   = "${var.contact_info}"
  }
}

resource "aws_subnet" "Private1a" {
  vpc_id                  = "${aws_vpc.qa.id}"
  cidr_block              = "10.101.101.0/24"
  availability_zone       = "us-east-1a"
  map_public_ip_on_launch = false

  tags {
    Name      = "Internal Facing 1A"
    CreatedBy = "Terraform"
    Contact   = "${var.contact_info}"
  }
}

resource "aws_subnet" "Private1b" {
  vpc_id                  = "${aws_vpc.qa.id}"
  cidr_block              = "10.101.102.0/24"
  availability_zone       = "us-east-1b"
  map_public_ip_on_launch = false

  tags {
    Name      = "Internal Facing 1B"
    CreatedBy = "Terraform"
    Contact   = "${var.contact_info}"
  }
}

resource "aws_subnet" "Private1c" {
  vpc_id                  = "${aws_vpc.qa.id}"
  cidr_block              = "10.101.103.0/24"
  availability_zone       = "us-east-1c"
  map_public_ip_on_launch = false

  tags {
    Name      = "Internal Facing 1C"
    CreatedBy = "Terraform"
    Contact   = "${var.contact_info}"
  }
}

resource "aws_subnet" "Private1d" {
  vpc_id                  = "${aws_vpc.qa.id}"
  cidr_block              = "10.101.104.0/24"
  availability_zone       = "us-east-1d"
  map_public_ip_on_launch = false

  tags {
    Name      = "Internal Facing 1D"
    CreatedBy = "Terraform"
    Contact   = "${var.contact_info}"
  }
}

resource "aws_subnet" "Private1e" {
  vpc_id                  = "${aws_vpc.qa.id}"
  cidr_block              = "10.101.105.0/24"
  availability_zone       = "us-east-1e"
  map_public_ip_on_launch = false

  tags {
    Name      = "Internal Facing 1E"
    CreatedBy = "Terraform"
    Contact   = "${var.contact_info}"
  }
}

resource "aws_subnet" "Private1f" {
  vpc_id                  = "${aws_vpc.qa.id}"
  cidr_block              = "10.101.106.0/24"
  availability_zone       = "us-east-1f"
  map_public_ip_on_launch = false

  tags {
    Name      = "Internal Facing 1F"
    CreatedBy = "Terraform"
    Contact   = "${var.contact_info}"
  }
}
