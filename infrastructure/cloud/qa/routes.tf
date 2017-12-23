resource "aws_internet_gateway" "gw" {
  vpc_id = "${aws_vpc.qa.id}"

  tags {
    Name      = "Gateway"
    CreatedBy = "Terraform"
    Contact   = "${var.contact_info}"
  }
}

resource "aws_route_table" "public" {
  vpc_id = "${aws_vpc.qa.id}"

  route {
    cidr_block = "0.0.0.0/0"
    gateway_id = "${aws_internet_gateway.gw.id}"
  }

  tags {
    Name      = "Public Route Table"
    CreatedBy = "Terraform"
    Contact   = "${var.contact_info}"
  }
}

resource "aws_route_table_association" "Public1a" {
  subnet_id      = "${aws_subnet.Public1a.id}"
  route_table_id = "${aws_route_table.public.id}"
}

resource "aws_route_table_association" "Public1b" {
  subnet_id      = "${aws_subnet.Public1b.id}"
  route_table_id = "${aws_route_table.public.id}"
}

resource "aws_route_table_association" "Public1c" {
  subnet_id      = "${aws_subnet.Public1c.id}"
  route_table_id = "${aws_route_table.public.id}"
}

resource "aws_route_table_association" "Public1d" {
  subnet_id      = "${aws_subnet.Public1d.id}"
  route_table_id = "${aws_route_table.public.id}"
}

resource "aws_route_table_association" "Public1e" {
  subnet_id      = "${aws_subnet.Public1e.id}"
  route_table_id = "${aws_route_table.public.id}"
}

resource "aws_route_table_association" "Public1f" {
  subnet_id      = "${aws_subnet.Public1f.id}"
  route_table_id = "${aws_route_table.public.id}"
}

resource "aws_route_table" "private" {
  vpc_id = "${aws_vpc.qa.id}"

  route {
    cidr_block     = "0.0.0.0/0"
    nat_gateway_id = "${aws_nat_gateway.nat.id}"
  }

  depends_on = ["aws_nat_gateway.nat"]

  tags {
    Name      = "Private Route Table"
    CreatedBy = "Terraform"
    Contact   = "${var.contact_info}"
  }
}

resource "aws_main_route_table_association" "private" {
  vpc_id         = "${aws_vpc.qa.id}"
  route_table_id = "${aws_route_table.private.id}"
}

resource "aws_route_table_association" "Private1a" {
  subnet_id      = "${aws_subnet.Private1a.id}"
  route_table_id = "${aws_route_table.private.id}"
}

resource "aws_route_table_association" "Private1b" {
  subnet_id      = "${aws_subnet.Private1b.id}"
  route_table_id = "${aws_route_table.private.id}"
}

resource "aws_route_table_association" "Private1c" {
  subnet_id      = "${aws_subnet.Private1c.id}"
  route_table_id = "${aws_route_table.private.id}"
}

resource "aws_route_table_association" "Private1d" {
  subnet_id      = "${aws_subnet.Private1d.id}"
  route_table_id = "${aws_route_table.private.id}"
}

resource "aws_route_table_association" "Private1e" {
  subnet_id      = "${aws_subnet.Private1e.id}"
  route_table_id = "${aws_route_table.private.id}"
}

resource "aws_route_table_association" "Private1f" {
  subnet_id      = "${aws_subnet.Private1f.id}"
  route_table_id = "${aws_route_table.private.id}"
}

resource "aws_eip" "nat_gatway" {
  vpc        = true
  depends_on = ["aws_internet_gateway.gw"]
}

resource "aws_nat_gateway" "nat" {
  allocation_id = "${aws_eip.nat_gatway.id}"
  subnet_id     = "${aws_subnet.Public1e.id}"

  depends_on = [
    "aws_internet_gateway.gw",
    "aws_eip.nat_gatway",
  ]

  tags {
    Name      = "Private Network NAT"
    CreatedBy = "Terraform"
    Contact   = "${var.contact_info}"
  }
}
