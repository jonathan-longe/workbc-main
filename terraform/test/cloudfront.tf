# cloudfront.tf

resource "random_integer" "cf_origin_id" {
  min = 1
  max = 100
}

resource "aws_cloudfront_distribution" "workbc" {

  count = var.cloudfront ? 1 : 0

  origin {
    custom_origin_config {
      http_port              = 80
      https_port             = 443
      origin_protocol_policy = "https-only"
      origin_ssl_protocols = ["TLSv1.2"]
      origin_keepalive_timeout = 60
      origin_read_timeout = 60
    }

    domain_name = var.cloudfront_origin_domain
    origin_id   = random_integer.cf_origin_id.result
	
	custom_header {
	  name = "X-Forwarded-Host"
	  value = "aws-test.workbc.ca"
	}
	
  }

  enabled         = true
  is_ipv6_enabled = true
  comment         = "WorkBC"

  default_cache_behavior {
    allowed_methods = [
      "DELETE",
      "GET",
      "HEAD",
      "OPTIONS",
      "PATCH",
      "POST",
    "PUT"]
    cached_methods = ["GET", "HEAD"]

    target_origin_id = random_integer.cf_origin_id.result

    forwarded_values {
      query_string = true

      cookies {
        forward = "all"
      }
    }

    viewer_protocol_policy = "redirect-to-https"
    min_ttl                = 0
    default_ttl            = 3600
    max_ttl                = 86400
	
    # SimpleCORS
    response_headers_policy_id = "60669652-455b-4ae9-85a4-c4c02393f86c"
  }

  price_class = "PriceClass_100"

  restrictions {
    geo_restriction {
      restriction_type = "whitelist"
      locations = ["CA"]
    }
  }

  tags = var.common_tags
  
  aliases = ["aws-test.workbc.ca"]

  viewer_certificate {
    #acm_certificate_arn = "arn:aws:acm:us-east-1:873424993519:certificate/0215bb2d-d224-4681-bf6b-227e9e82f29f"
    acm_certificate_arn = "arn:aws:acm:ca-central-1:054099626264:certificate/4e63f03d-8ea4-4788-9dea-73d77b48d93b"
    ssl_support_method = "sni-only"
  }
}

output "cloudfront_url" {
  value = "https://${aws_cloudfront_distribution.workbc[0].domain_name}"
}

