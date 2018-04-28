data "aws_iam_policy_document" "edi_s3_role_policy" {
  statement {
    actions = [
      "s3:GetObject",
      "s3:ListBucket",
      "s3:ListObjects",
      "s3:PutObject",
    ]
  }
}

resource "aws_iam_role" "edi_s3" {
  name        = "facet-edi-s3"
  description = "Allows S3 access to specified buckets for a VAN entry point"

  assume_role_policy = "${data.aws_iam_policy_document.edi_s3_role_policy.json}"
}
