resource "aws_security_group_rule" "allow_internet_http_to_alb" {
  description = "Allow big scary internet IPv4 unencrypted traffic to the ALB for rerouting to secure"

  type      = "ingress"
  from_port = 80
  to_port   = 80
  protocol  = "tcp"

  cidr_blocks = ["0.0.0.0/0"]

  security_group_id = "${aws_security_group.public_load_balancer.id}"
}

resource "aws_security_group_rule" "allow_internet_http_to_alb" {
  description = "Allow big scary internet IPv4 encrypted traffic to the ALB"

  type      = "ingress"
  from_port = 443
  to_port   = 443
  protocol  = "tcp"

  cidr_blocks = ["0.0.0.0/0"]

  security_group_id = "${aws_security_group.public_load_balancer.id}"
}

resource "aws_security_group_rule" "allow_internet6_http_to_alb" {
  description = "Allow big scary internet IPv6 unencrypted traffic to the ALB for rerouting to secure"

  type      = "ingress"
  from_port = 80
  to_port   = 80
  protocol  = "tcp"

  ipv6_cidr_blocks = ["::/0"]

  security_group_id = "${aws_security_group.public_load_balancer.id}"
}

resource "aws_security_group_rule" "allow_internet6_http_to_alb" {
  description = "Allow big scary internet IPv6 encrypted traffic to the ALB"

  type      = "ingress"
  from_port = 443
  to_port   = 443
  protocol  = "tcp"

  ipv6_cidr_blocks = ["::/0"]

  security_group_id = "${aws_security_group.public_load_balancer.id}"
}

resource "aws_security_group_rule" "allow_traffic_out_from_alb_to_compute_resources" {
  description = "Allow ALB to communicate with compute clusters"

  type      = "egress"
  from_port = 443
  to_port   = 443
  protocol  = "tcp"

  source_security_group_id = "${aws_security_group.web_application.id}"

  security_group_id = "${aws_security_group.public_load_balancer.id}"
}

resource "aws_security_group_rule" "allow_traffic_in_from_alb_to_compute_resources" {
  description = "Allow incoming traffic from ALB to compute clusters"

  type      = "ingress"
  from_port = 443
  to_port   = 443
  protocol  = "tcp"

  source_security_group_id = "${aws_security_group.public_load_balancer.id}"

  security_group_id = "${aws_security_group.web_application.id}"
}

resource "aws_security_group_rule" "allow_traffic_out_from_compute_resources_to_database" {
  description = "Allow outgoing traffic from Compute Clusters to Database Cluster"

  type      = "egress"
  from_port = 5432
  to_port   = 5432
  protocol  = "tcp"

  source_security_group_id = "${aws_security_group.database.id}"

  security_group_id = "${aws_security_group.web_application.id}"
}

resource "aws_security_group_rule" "allow_traffic_in_from_compute_resources_to_database" {
  description = "Allow incoming traffic from Compute Clusters to Database Cluster"

  type      = "ingress"
  from_port = 5432
  to_port   = 5432
  protocol  = "tcp"

  source_security_group_id = "${aws_security_group.web_application.id}"

  security_group_id = "${aws_security_group.database.id}"
}

resource "aws_security_group_rule" "allow_traffic_out_from_compute_resources_to_cache" {
  description = "Allow outgoing traffic from Compute Clusters to Caching Cluster"

  type      = "egress"
  from_port = 6379
  to_port   = 6379
  protocol  = "tcp"

  source_security_group_id = "${aws_security_group.cache.id}"

  security_group_id = "${aws_security_group.web_application.id}"
}

resource "aws_security_group_rule" "allow_traffic_in_from_compute_resources_to_cache" {
  description = "Allow incoming traffic from Compute Clusters to Caching Cluster"

  type      = "ingress"
  from_port = 6379
  to_port   = 6379
  protocol  = "tcp"

  source_security_group_id = "${aws_security_group.web_application.id}"

  security_group_id = "${aws_security_group.cache.id}"
}

resource "aws_security_group_rule" "allow_remote_admin_in_from_approved_sources_to_bastion" {
  description = "Allow incoming traffic from approved administrators to Bastion instances"

  type      = "ingress"
  from_port = 22
  to_port   = 22
  protocol  = "tcp"

  cidr_blocks = ["${var.source_cidr}"]

  security_group_id = "${aws_security_group.bastion.id}"
}

resource "aws_security_group_rule" "allow_admin_out_from_bastion_to_compute" {
  description = "Allow remote administration access out from Bastion instances to VPC compute clusters"

  type      = "egress"
  from_port = 22
  to_port   = 22
  protocol  = "tcp"

  source_security_group_id = "${aws_security_group.web_application.id}"

  security_group_id = "${aws_security_group.bastion.id}"
}

resource "aws_security_group_rule" "allow_admin_in_from_bastion_to_compute" {
  description = "Allow remote administration access in from Bastion instances to VPC compute clusters"

  type      = "ingress"
  from_port = 22
  to_port   = 22
  protocol  = "tcp"

  source_security_group_id = "${aws_security_group.bastion.id}"

  security_group_id = "${aws_security_group.web_application.id}"
}

resource "aws_security_group_rule" "allow_database_access_out_from_bastion" {
  description = "Allow access to database out from Bastion instance to lock database access into vpc"

  type      = "egress"
  from_port = 5432
  to_port   = 5432
  protocol  = "tcp"

  source_security_group_id = "${aws_security_group.database.id}"

  security_group_id = "${aws_security_group.bastion.id}"
}

esource "aws_security_group_rule" "allow_database_access_in_from_bastion" {
  description = "Allow access to database in from Bastion instance to lock database access into vpc"

  type      = "ingress"
  from_port = 5432
  to_port   = 5432
  protocol  = "tcp"

  source_security_group_id = "${aws_security_group.bastion.id}"

  security_group_id = "${aws_security_group.database.id}"
}
