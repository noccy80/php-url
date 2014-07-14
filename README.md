URL
===

## Installing

With composer:

        $ composer require noccylabs/url:0.1.*

## Using

### To canonize URLs

If you have an input URL that may not be fully canonized, pass it through the
`Url::canonizeUrl()` static method:

        $ugly = "google.com";
        $pretty = Url::canonizeUrl($ugly, "https");
        echo $pretty; // <- https://google.com


### To apply partial URLs to base URLs

If you are crawling a page, this can be used to find the appropriate linked
resource names from the document:

        $base = new Url("http://www.domain.tld/some/page.html");
        $image = "../image.jpg";
        $image_url = $base->apply($image)->getUrl();
        echo $image_url; // <- http://www.domain.tld/image.jpg


### To create and manipulate URLs


        $url = new Url();
        $url->setHost("google.com");
        $qs = new QueryString();
        $qs->set("q", "Hello World");
        $url->query = $qs;
        echo $url; // <- http://google.com?q=Hello%20World
