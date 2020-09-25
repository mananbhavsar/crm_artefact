<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\HttpFoundation\Tests;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Session\Storage\MockArraySessionStorage;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;

class RequestTest extends TestCase
{
    public function testInitialize()
    {
        $request = new Request();

        $request->initialize(array('foo' => 'bar'));
        $this->assertEquals('bar', $request->query->get('foo'), '->initialize() takes an array of query parameters as its first argument');

        $request->initialize(array(), array('foo' => 'bar'));
        $this->assertEquals('bar', $request->request->get('foo'), '->initialize() takes an array of request parameters as its second argument');

        $request->initialize(array(), array(), array('foo' => 'bar'));
        $this->assertEquals('bar', $request->attributes->get('foo'), '->initialize() takes an array of attributes as its third argument');

        $request->initialize(array(), array(), array(), array(), array(), array('HTTP_FOO' => 'bar'));
        $this->assertEquals('bar', $request->headers->get('FOO'), '->initialize() takes an array of HTTP headers as its sixth argument');
    }

    public function testGetLocale()
    {
        $request = new Request();
        $request->setLocale('pl');
        $locale = $request->getLocale();
        $this->assertEquals('pl', $locale);
    }

    public function testGetUser()
    {
        $request = Request::create('http://user_test:password_test@test.com/');
        $user = $request->getUser();

        $this->assertEquals('user_test', $user);
    }

    public function testGetPassword()
    {
        $request = Request::create('http://user_test:password_test@test.com/');
        $password = $request->getPassword();

        $this->assertEquals('password_test', $password);
    }

    public function testIsNoCache()
    {
        $request = new Request();
        $isNoCache = $request->isNoCache();

        $this->assertFalse($isNoCache);
    }

    public function testGetContentType()
    {
        $request = new Request();
        $contentType = $request->getContentType();

        $this->assertNull($contentType);
    }

    public function testSetDefaultLocale()
    {
        $request = new Request();
        $request->setDefaultLocale('pl');
        $locale = $request->getLocale();

        $this->assertEquals('pl', $locale);
    }

    public function testCreate()
    {
        $request = Request::create('http://test.com/foo?bar=baz');
        $this->assertEquals('http://test.com/foo?bar=baz', $request->getUri());
        $this->assertEquals('/foo', $request->getPathInfo());
        $this->assertEquals('bar=baz', $request->getQueryString());
        $this->assertEquals(80, $request->getPort());
        $this->assertEquals('test.com', $request->getHttpHost());
        $this->assertFalse($request->isSecure());

        $request = Request::create('http://test.com/foo', 'GET', array('bar' => 'baz'));
        $this->assertEquals('http://test.com/foo?bar=baz', $request->getUri());
        $this->assertEquals('/foo', $request->getPathInfo());
        $this->assertEquals('bar=baz', $request->getQueryString());
        $this->assertEquals(80, $request->getPort());
        $this->assertEquals('test.com', $request->getHttpHost());
        $this->assertFalse($request->isSecure());

        $request = Request::create('http://test.com/foo?bar=foo', 'GET', array('bar' => 'baz'));
        $this->assertEquals('http://test.com/foo?bar=baz', $request->getUri());
        $this->assertEquals('/foo', $request->getPathInfo());
        $this->assertEquals('bar=baz', $request->getQueryString());
        $this->assertEquals(80, $request->getPort());
        $this->assertEquals('test.com', $request->getHttpHost());
        $this->assertFalse($request->isSecure());

        $request = Request::create('https://test.com/foo?bar=baz');
        $this->assertEquals('https://test.com/foo?bar=baz', $request->getUri());
        $this->assertEquals('/foo', $request->getPathInfo());
        $this->assertEquals('bar=baz', $request->getQueryString());
        $this->assertEquals(443, $request->getPort());
        $this->assertEquals('test.com', $request->getHttpHost());
        $this->assertTrue($request->isSecure());

        $request = Request::create('test.com:90/foo');
        $this->assertEquals('http://test.com:90/foo', $request->getUri());
        $this->assertEquals('/foo', $request->getPathInfo());
        $this->assertEquals('test.com', $request->getHost());
        $this->assertEquals('test.com:90', $request->getHttpHost());
        $this->assertEquals(90, $request->getPort());
        $this->assertFalse($request->isSecure());

        $request = Request::create('https://test.com:90/foo');
        $this->assertEquals('https://test.com:90/foo', $request->getUri());
        $this->assertEquals('/foo', $request->getPathInfo());
        $this->assertEquals('test.com', $request->getHost());
        $this->assertEquals('test.com:90', $request->getHttpHost());
        $this->assertEquals(90, $request->getPort());
        $this->assertTrue($request->isSecure());

        $request = Request::create('https://127.0.0.1:90/foo');
        $this->assertEquals('https://127.0.0.1:90/foo', $request->getUri());
        $this->assertEquals('/foo', $request->getPathInfo());
        $this->assertEquals('127.0.0.1', $request->getHost());
        $this->assertEquals('127.0.0.1:90', $request->getHttpHost());
        $this->assertEquals(90, $request->getPort());
        $this->assertTrue($request->isSecure());

        $request = Request::create('https://[::1]:90/foo');
        $this->assertEquals('https://[::1]:90/foo', $request->getUri());
        $this->assertEquals('/foo', $request->getPathInfo());
        $this->assertEquals('[::1]', $request->getHost());
        $this->assertEquals('[::1]:90', $request->getHttpHost());
        $this->assertEquals(90, $request->getPort());
        $this->assertTrue($request->isSecure());

        $request = Request::create('https://[::1]/foo');
        $this->assertEquals('https://[::1]/foo', $request->getUri());
        $this->assertEquals('/foo', $request->getPathInfo());
        $this->assertEquals('[::1]', $request->getHost());
        $this->assertEquals('[::1]', $request->getHttpHost());
        $this->assertEquals(443, $request->getPort());
        $this->assertTrue($request->isSecure());

        $json = '{"jsonrpc":"2.0","method":"echo","id":7,"params":["Hello World"]}';
        $request = Request::create('http://example.com/jsonrpc', 'POST', array(), array(), array(), array(), $json);
        $this->assertEquals($json, $request->getContent());
        $this->assertFalse($request->isSecure());

        $request = Request::create('http://test.com');
        $this->assertEquals('http://test.com/', $request->getUri());
        $this->assertEquals('/', $request->getPathInfo());
        $this->assertEquals('', $request->getQueryString());
        $this->assertEquals(80, $request->getPort());
        $this->assertEquals('test.com', $request->getHttpHost());
        $this->assertFalse($request->isSecure());

        $request = Request::create('http://test.com?test=1');
        $this->assertEquals('http://test.com/?test=1', $request->getUri());
        $this->assertEquals('/', $request->getPathInfo());
        $this->assertEquals('test=1', $request->getQueryString());
        $this->assertEquals(80, $request->getPort());
        $this->assertEquals('test.com', $request->getHttpHost());
        $this->assertFalse($request->isSecure());

        $request = Request::create('http://test.com:90/?test=1');
        $this->assertEquals('http://test.com:90/?test=1', $request->getUri());
        $this->assertEquals('/', $request->getPathInfo());
        $this->assertEquals('test=1', $request->getQueryString());
        $this->assertEquals(90, $request->getPort());
        $this->assertEquals('test.com:90', $request->getHttpHost());
        $this->assertFalse($request->isSecure());

        $request = Request::create('http://username:password@test.com');
        $this->assertEquals('http://test.com/', $request->getUri());
        $this->assertEquals('/', $request->getPathInfo());
        $this->assertEquals('', $request->getQueryString());
        $this->assertEquals(80, $request->getPort());
        $this->assertEquals('test.com', $request->getHttpHost());
        $this->assertEquals('username', $request->getUser());
        $this->assertEquals('password', $request->getPassword());
        $this->assertFalse($request->isSecure());

        $request = Request::create('http://username@test.com');
        $this->assertEquals('http://test.com/', $request->getUri());
        $this->assertEquals('/', $request->getPathInfo());
        $this->assertEquals('', $request->getQueryString());
        $this->assertEquals(80, $request->getPort());
        $this->assertEquals('test.com', $request->getHttpHost());
        $this->assertEquals('username', $request->getUser());
        $this->assertSame('', $request->getPassword());
        $this->assertFalse($request->isSecure());

        $request = Request::create('http://test.com/?foo');
        $this->assertEquals('/?foo', $request->getRequestUri());
        $this->assertEquals(array('foo' => ''), $request->query->all());

        // assume rewrite rule: (.*) --> app/app.php; app/ is a symlink to a symfony web/ directory
        $request = Request::create('http://test.com/apparthotel-1234', 'GET', array(), array(), array(),
            array(
                'DOCUMENT_ROOT' => '/var/www/www.test.com',
                'SCRIPT_FILENAME' => '/var/www/www.test.com/app/app.php',
                'SCRIPT_NAME' => '/app/app.php',
                'PHP_SELF' => '/app/app.php/apparthotel-1234',
            ));
        $this->assertEquals('http://test.com/apparthotel-1234', $request->getUri());
        $this->assertEquals('/apparthotel-1234', $request->getPathInfo());
        $this->assertEquals('', $request->getQueryString());
        $this->assertEquals(80, $request->getPort());
        $this->assertEquals('test.com', $request->getHttpHost());
        $this->assertFalse($request->isSecure());
    }

    public function testCreateCheckPrecedence()
    {
        // server is used by default
        $request = Request::create('/', 'DELETE', array(), array(), array(), array(
            'HTTP_HOST' => 'example.com',
            'HTTPS' => 'on',
            'SERVER_PORT' => 443,
            'PHP_AUTH_USER' => 'fabien',
            'PHP_AUTH_PW' => 'pa$$',
            'QUERY_STRING' => 'foo=bar',
            'CONTENT_TYPE' => 'application/json',
        ));
        $this->assertEquals('example.com', $request->getHost());
        $this->assertEquals(443, $request->getPort());
        $this->assertTrue($request->isSecure());
        $this->assertEquals('fabien', $request->getUser());
        $this->assertEquals('pa$$', $request->getPassword());
        $this->assertEquals('', $request->getQueryString());
        $this->assertEquals('application/json', $request->headers->get('CONTENT_TYPE'));

        // URI has precedence over server
        $request = Request::create('http://thomas:pokemon@example.net:8080/?foo=bar', 'GET', array(), array(), array(), array(
            'HTTP_HOST' => 'example.com',
            'HTTPS' => 'on',
            'SERVER_PORT' => 443,
        ));
        $this->assertEquals('example.net', $request->getHost());
        $this->assertEquals(8080, $request->getPort());
        $this->assertFalse($request->isSecure());
        $this->assertEquals('thomas', $request->getUser());
        $this->assertEquals('pokemon', $request->getPassword());
        $this->assertEquals('foo=bar', $request->getQueryString());
    }

    public function testDuplicate()
    {
        $request = new Request(array('foo' => 'bar'), array('foo' => 'bar'), array('foo' => 'bar'), array(), array(), array('HTTP_FOO' => 'bar'));
        $dup = $request->duplicate();

        $this->assertEquals($request->query->all(), $dup->query->all(), '->duplicate() duplicates a request an copy the current query parameters');
        $this->assertEquals($request->request->all(), $dup->request->all(), '->duplicate() duplicates a request an copy the current request parameters');
        $this->assertEquals($request->attributes->all(), $dup->attributes->all(), '->duplicate() duplicates a request an copy the current attributes');
        $this->assertEquals($request->headers->all(), $dup->headers->all(), '->duplicate() duplicates a request an copy the current HTTP headers');

        $dup = $request->duplicate(array('foo' => 'foobar'), array('foo' => 'foobar'), array('foo' => 'foobar'), array(), array(), array('HTTP_FOO' => 'foobar'));

        $this->assertEquals(array('foo' => 'foobar'), $dup->query->all(), '->duplicate() overrides the query parameters if provided');
        $this->assertEquals(array('foo' => 'foobar'), $dup->request->all(), '->duplicate() overrides the request parameters if provided');
        $this->assertEquals(array('foo' => 'foobar'), $dup->attributes->all(), '->duplicate() overrides the attributes if provided');
        $this->assertEquals(array('foo' => array('foobar')), $dup->headers->all(), '->duplicate() overrides the HTTP header if provided');
    }

    public function testDuplicateWithFormat()
    {
        $request = new Request(array(), array(), array('_format' => 'json'));
        $dup = $request->duplicate();

        $this->assertEquals('json', $dup->getRequestFormat());
        $this->assertEquals('json', $dup->attributes->get('_format'));

        $request = new Request();
        $request->setRequestFormat('xml');
        $dup = $request->duplicate();

        $this->assertEquals('xml', $dup->getRequestFormat());
    }

    /**
     * @dataProvider getFormatToMimeTypeMapProvider
     */
    public function testGetFormatFromMimeType($format, $mimeTypes)
    {
        $request = new Request();
        foreach ($mimeTypes as $mime) {
            $this->assertEquals($format, $request->getFormat($mime));
        }
        $request->setFormat($format, $mimeTypes);
        foreach ($mimeTypes as $mime) {
            $this->assertEquals($format, $request->getFormat($mime));
        }
    }

    public function testGetFormatFromMimeTypeWithParameters()
    {
        $request = new Request();
        $this->assertEquals('json', $request->getFormat('application/json; charset=utf-8'));
    }

    /**
     * @dataProvider getFormatToMimeTypeMapProvider
     */
    public function testGetMimeTypeFromFormat($format, $mimeTypes)
    {
        if (null !== $format) {
            $request = new Request();
            $this->assertEquals($mimeTypes[0], $request->getMimeType($format));
        }
    }

    public function testGetFormatWithCustomMimeType()
    {
        $request = new Request();
        $request->setFormat('custom', 'application/vnd.foo.api;myversion=2.3');
        $this->assertEquals('custom', $request->getFormat('application/vnd.foo.api;myversion=2.3'));
    }

    public function getFormatToMimeTypeMapProvider()
    {
        return array(
            array(null, array(null, 'unexistent-mime-type')),
            array('txt', array('text/plain')),
            array('js', array('application/javascript', 'application/x-javascript', 'text/javascript')),
            array('css', array('text/css')),
            array('json', array('application/json', 'application/x-json')),
            array('xml', array('text/xml', 'application/xml', 'application/x-xml')),
            array('rdf', array('application/rdf+xml')),
            array('atom', array('application/atom+xml')),
        );
    }

    public function testGetUri()
    {
        $server = array();

        // Standard Request on non default PORT
        // http://host:8080/index.php/path/info?query=string

        $server['HTTP_HOST'] = 'host:8080';
        $server['SERVER_NAME'] = 'servername';
        $server['SERVER_PORT'] = '8080';

        $server['QUERY_STRING'] = 'query=string';
        $server['REQUEST_URI'] = '/index.php/path/info?query=string';
        $server['SCRIPT_NAME'] = '/index.php';
        $server['PATH_INFO'] = '/path/info';
        $server['PATH_TRANSLATED'] = 'redirect:/index.php/path/info';
        $server['PHP_SELF'] = '/index_dev.php/path/info';
        $server['SCRIPT_FILENAME'] = '/some/where/index.php';

        $request = new Request();

        $request->initialize(array(), array(), array(), array(), array(), $server);

        $this->assertEquals('http://host:8080/index.php/path/info?query=string', $request->getUri(), '->getUri() with non default port');

        // Use std port number
        $server['HTTP_HOST'] = 'host';
        $server['SERVER_NAME'] = 'servername';
        $server['SERVER_PORT'] = '80';

        $request->initialize(array(), array(), array(), array(), array(), $server);

        $this->assertEquals('http://host/index.php/path/info?query=string', $request->getUri(), '->getUri() with default port');

        // Without HOST HEADER
        unset($server['HTTP_HOST']);
        $server['SERVER_NAME'] = 'servername';
        $server['SERVER_PORT'] = '80';

        $request->initialize(array(), array(), array(), array(), array(), $server);

        $this->assertEquals('http://servername/index.php/path/info?query=string', $request->getUri(), '->getUri() with default port without HOST_HEADER');

        // Request with URL REWRITING (hide index.php)
        //   RewriteCond %{REQUEST_FILENAME} !-f
        //   RewriteRule ^(.*)$ index.php [QSA,L]
        // http://host:8080/path/info?query=string
        $server = array();
        $server['HTTP_HOST'] = 'host:8080';
        $server['SERVER_NAME'] = 'servername';
        $server['SERVER_PORT'] = '8080';

        $server['REDIRECT_QUERY_STRING'] = 'query=string';
        $server['REDIRECT_URL'] = '/path/info';
        $server['SCRIPT_NAME'] = '/index.php';
        $server['QUERY_STRING'] = 'query=string';
        $server['REQUEST_URI'] = '/path/info?toto=test&1=1';
        $server['SCRIPT_NAME'] = '/index.php';
        $server['PHP_SELF'] = '/index.php';
        $server['SCRIPT_FILENAME'] = '/some/where/index.php';

        $request->initialize(array(), array(), array(), array(), array(), $server);
        $this->assertEquals('http://host:8080/path/info?query=string', $request->getUri(), '->getUri() with rewrite');

        // Use std port number
        //  http://host/path/info?query=string
        $server['HTTP_HOST'] = 'host';
        $server['SERVER_NAME'] = 'servername';
        $server['SERVER_PORT'] = '80';

        $request->initialize(array(), array(), array(), array(), array(), $server);

        $this->assertEquals('http://host/path/info?query=string', $request->getUri(), '->getUri() with rewrite and default port');

        // Without HOST HEADER
        unset($server['HTTP_HOST']);
        $server['SERVER_NAME'] = 'servername';
        $server['SERVER_PORT'] = '80';

        $request->initialize(array(), array(), array(), array(), array(), $server);

        $this->assertEquals('http://servername/path/info?query=string', $request->getUri(), '->getUri() with rewrite, default port without HOST_HEADER');

        // With encoded characters

        $server = array(
            'HTTP_HOST' => 'host:8080',
            'SERVER_NAME' => 'servername',
            'SERVER_PORT' => '8080',
            'QUERY_STRING' => 'query=string',
            'REQUEST_URI' => '/ba%20se/index_dev.php/foo%20bar/in+fo?query=string',
            'SCRIPT_NAME' => '/ba se/index_dev.php',
            'PATH_TRANSLATED' => 'redirect:/index.php/foo bar/in+fo',
            'PHP_SELF' => '/ba se/index_dev.php/path/info',
            'SCRIPT_FILENAME' => '/some/where/ba se/index_dev.php',
        );

        $request->initialize(array(), array(), array(), array(), array(), $server);

        $this->assertEquals(
            'http://host:8080/ba%20se/index_dev.php/foo%20bar/in+fo?query=string',
            $request->getUri()
        );

        // with user info

        $server['PHP_AUTH_USER'] = 'fabien';
        $request->initialize(array(), array(), array(), array(), array(), $server);
        $this->assertEquals('http://host:8080/ba%20se/index_dev.php/foo%20bar/in+fo?query=string', $request->getUri());

        $server['PHP_AUTH_PW'] = 'symfony';
        $request->initialize(array(), array(), array(), array(), array(), $server);
        $this->assertEquals('http://host:8080/ba%20se/index_dev.php/foo%20bar/in+fo?query=string', $request->getUri());
    }

    public function testGetUriForPath()
    {
        $request = Request::create('http://test.com/foo?bar=baz');
        $this->assertEquals('http://test.com/some/path', $request->getUriForPath('/some/path'));

        $request = Request::create('http://test.com:90/foo?bar=baz');
        $this->assertEquals('http://test.com:90/some/path', $request->getUriForPath('/some/path'));

        $request = Request::create('https://test.com/foo?bar=baz');
        $this->assertEquals('https://test.com/some/path', $request->getUriForPath('/some/path'));

        $request = Request::create('https://test.com:90/foo?bar=baz');
        $this->assertEquals('https://test.com:90/some/path', $request->getUriForPath('/some/path'));

        $server = array();

        // Standard Request on non default PORT
        // http://host:8080/index.php/path/info?query=string

        $server['HTTP_HOST'] = 'host:8080';
        $server['SERVER_NAME'] = 'servername';
        $server['SERVER_PORT'] = '8080';

        $server['QUERY_STRING'] = 'query=string';
        $server['REQUEST_URI'] = '/index.php/path/info?query=string';
        $server['SCRIPT_NAME'] = '/index.php';
        $server['PATH_INFO'] = '/path/info';
        $server['PATH_TRANSLATED'] = 'redirect:/index.php/path/info';
        $server['PHP_SELF'] = '/index_dev.php/path/info';
        $server['SCRIPT_FILENAME'] = '/some/where/index.php';

        $request = new Request();

        $request->initialize(array(), array(), array(), array(), array(), $server);

        $this->assertEquals('http://host:8080/index.php/some/path', $request->getUriForPath('/some/path'), '->getUriForPath() with non default port');

        // Use std port number
        $server['HTTP_HOST'] = 'host';
        $server['SERVER_NAME'] = 'servername';
        $server['SERVER_PORT'] = '80';

        $request->initialize(array(), array(), array(), array(), array(), $server);

        $this->assertEquals('http://host/index.php/some/path', $request->getUriForPath('/some/path'), '->getUriForPath() with default port');

        // Without HOST HEADER
        unset($server['HTTP_HOST']);
        $server['SERVER_NAME'] = 'servername';
        $server['SERVER_PORT'] = '80';

        $request->initialize(array(), array(), array(), array(), array(), $server);

        $this->assertEquals('http://servername/index.php/some/path', $request->getUriForPath('/some/path'), '->getUriForPath() with default port without HOST_HEADER');

        // Request with URL REWRITING (hide index.php)
        //   RewriteCond %{REQUEST_FILENAME} !-f
        //   RewriteRule ^(.*)$ index.php [QSA,L]
        // http://host:8080/path/info?query=string
        $server = array();
        $server['HTTP_HOST'] = 'host:8080';
        $server['SERVER_NAME'] = 'servername';
        $server['SERVER_PORT'] = '8080';

        $server['REDIRECT_QUERY_STRING'] = 'query=string';
        $server['REDIRECT_URL'] = '/path/info';
        $server['SCRIPT_NAME'] = '/index.php';
        $server['QUERY_STRING'] = 'query=string';
        $server['REQUEST_URI'] = '/path/info?toto=test&1=1';
        $server['SCRIPT_NAME'] = '/index.php';
        $server['PHP_SELF'] = '/index.php';
        $server['SCRIPT_FILENAME'] = '/some/where/index.php';

        $request->initialize(array(), array(), array(), array(), array(), $server);
        $this->assertEquals('http://host:8080/some/path', $request->getUriForPath('/some/path'), '->getUri() with rewrite');

        // Use std port number
        //  http://host/path/info?query=string
        $server['HTTP_HOST'] = 'host';
        $server['SERVER_NAME'] = 'servername';
        $server['SERVER_PORT'] = '80';

        $request->initialize(array(), array(), array(), array(), array(), $server);

        $this->assertEquals('http://host/some/path', $request->getUriForPath('/some/path'), '->getUriForPath() with rewrite and default port');

        // Without HOST HEADER
        unset($server['HTTP_HOST']);
        $server['SERVER_NAME'] = 'servername';
        $server['SERVER_PORT'] = '80';

        $request->initialize(array(), array(), array(), array(), array(), $server);

        $this->assertEquals('http://servername/some/path', $request->getUriForPath('/some/path'), '->getUriForPath() with rewrite, default port without HOST_HEADER');
        $this->assertEquals('servername', $request->getHttpHost());

        // with user info

        $server['PHP_AUTH_USER'] = 'fabien';
        $request->initialize(array(), array(), array(), array(), array(), $server);
        $this->assertEquals('http://servername/some/path', $request->getUriForPath('/some/path'));

        $server['PHP_AUTH_PW'] = 'symfony';
        $request->initialize(array(), array(), array(), array(), array(), $server);
        $this->assertEquals('http://servername/some/path', $request->getUriForPath('/some/path'));
    }

    /**
     * @dataProvider getRelativeUriForPathData()
     */
    public function testGetRelativeUriForPath($expected, $pathinfo, $path)
    {
        $this->assertEquals($expected, Request::create($pathinfo)->getRelativeUriForPath($path));
    }

    public function getRelativeUriForPathData()
    {
        return array(
            array('me.png', '/foo', '/me.png'),
            array('../me.png', '/foo/bar', '/me.png'),
            array('me.png', '/foo/bar', '/foo/me.png'),
            array('../baz/me.png', '/foo/bar/b', '/foo/baz/me.png'),
            array('../../fooz/baz/me.png', '/foo/bar/b', '/fooz/baz/me.png'),
            array('baz/me.png', '/foo/bar/b', 'baz/me.png'),
        );
    }

    public function testGetUserInfo()
    {
        $request = new Request();

        $server = array('PHP_AUTH_USER' => 'fabien');
        $request->initialize(array(), array(), array(), array(), array(), $server);
        $this->assertEquals('fabien', $request->getUserInfo());

        $server['PHP_AUTH_USER'] = '0';
        $request->initialize(array(), array(), array(), array(), array(), $server);
        $this->assertEquals('0', $request->getUserInfo());

        $server['PHP_AUTH_PW'] = '0';
        $request->initialize(array(), array(), array(), array(), array(), $server);
        $this->assertEquals('0:0', $request->getUserInfo());
    }

    public function testGetSchemeAndHttpHost()
    {
        $request = new Request();

        $server = array();
        $server['SERVER_NAME'] = 'servername';
        $server['SERVER_PORT'] = '90';
        $request->initialize(array(), array(), array(), array(), array(), $server);
        $this->assertEquals('http://servername:90', $request->getSchemeAndHttpHost());

        $server['PHP_AUTH_USER'] = 'fabien';
        $request->initialize(array(), array(), array(), array(), array(), $server);
        $this->assertEquals('http://servername:90', $request->getSchemeAndHttpHost());

        $server['PHP_AUTH_USER'] = '0';
        $request->initialize(array(), array(), array(), array(), array(), $server);
        $this->assertEquals('http://servername:90', $request->getSchemeAndHttpHost());

        $server['PHP_AUTH_PW'] = '0';
        $request->initialize(array(), array(), array(), array(), array(), $server);
        $this->assertEquals('http://servername:90', $request->getSchemeAndHttpHost());
    }

    /**
     * @dataProvider getQueryStringNormalizationData
     */
    public function testGetQueryString($query, $expectedQuery, $msg)
    {
        $request = new Request();

        $request->server->set('QUERY_STRING', $query);
        $this->assertSame($expectedQuery, $request->getQueryString(), $msg);
    }

    public function getQueryStringNormalizationData()
    {
        return array(
            array('foo', 'foo', 'works with valueless parameters'),
            array('foo=', 'foo=', 'includes a dangling equal sign'),
            array('bar=&foo=bar', 'bar=&foo=bar', '->works with empty parameters'),
            array('foo=bar&bar=', 'bar=&foo=bar', 'sorts keys alphabetically'),

            // GET parameters, that are submitted from a HTML form, encode spaces as "+" by default (as defined in enctype application/x-www-form-urlencoded).
            // PHP also converts "+" to spaces when filling the global _GET or when using the function parse_str.
            array('him=John%20Doe&her=Jane+Doe', 'her=Jane%20Doe&him=John%20Doe', 'normalizes spaces in both encodings "%20" and "+"'),

            array('foo[]=1&foo[]=2', 'foo%5B%5D=1&foo%5B%5D=2', 'allows array notation'),
            array('foo=1&foo=2', 'foo=1&foo=2', 'allows repeated parameters'),
            array('pa%3Dram=foo%26bar%3Dbaz&test=test', 'pa%3Dram=foo%26bar%3Dbaz&test=test', 'works with encoded delimiters'),
            array('0', '0', 'allows "0"'),
            array('Jane Doe&John%20Doe', 'Jane%20Doe&John%20Doe', 'normalizes encoding in keys'),
            array('her=Jane Doe&him=John%20Doe', 'her=Jane%20Doe&him=John%20Doe', 'normalizes encoding in values'),
            array('foo=bar&&&test&&', 'foo=bar&test', 'removes unneeded delimiters'),
            array('formula=e=m*c^2', 'formula=e%3Dm%2Ac%5E2', 'correctly treats only the first "=" as delimiter and the next as value'),

            // Ignore pairs with empty key, even if there was a value, e.g. "=value", as such nameless values cannot be retrieved anyway.
            // PHP also does not include them when building _GET.
            array('foo=bar&=a=b&=x=y', 'foo=bar', 'removes params with empty key'),
        );
    }

    public function testGetQueryStringReturnsNull()
    {
        $request = new Request();

        $this->assertNull($request->getQueryString(), '->getQueryString() returns null for non-existent query string');

        $request->server->set('QUERY_STRING', '');
        $this->assertNull($request->getQueryString(), '->getQueryString() returns null for empty query string');
    }

    public function testGetHost()
    {
        $request = new Request();

        $request->initialize(array('foo' => 'bar'));
        $this->assertEquals('', $request->getHost(), '->getHost() return empty string if not initialized');

        $request->initialize(array(), array(), array(), array(), array(), array('HTTP_HOST' => 'www.example.com'));
        $this->assertEquals('www.example.com', $request->getHost(), '->getHost() from Host Header');

        // Host header with port number
        $request->initialize(array(), array(), array(), array(), array(), array('HTTP_HOST' => 'www.example.com:8080'));
        $this->assertEquals('www.example.com', $request->getHost(), '->getHost() from Host Header with port number');

        // Server values
        $request->initialize(array(), array(), array(), array(), array(), array('SERVER_NAME' => 'www.example.com'));
        $this->assertEquals('www.example.com', $request->getHost(), '->getHost() from server name');

        $request->initialize(array(), array(), array(), array(), array(), array('SERVER_NAME' => 'www.example.com', 'HTTP_HOST' => 'www.host.com'));
        $this->assertEquals('www.host.com', $request->getHost(), '->getHost() value from Host header has priority over SERVER_NAME ');
    }

    public function testGetPort()
    {
        $request = Request::create('http://example.com', 'GET', array(), array(), array(), array(
            'HTTP_X_FORWARDED_PROTO' => 'https',
            'HTTP_X_FORWARDED_PORT' => '443',
        ));
        $port = $request->getPort();

        $this->assertEquals(80, $port, 'Without trusted proxies FORWARDED_PROTO and FORWARDED_PORT are ignored.');

        Request::setTrustedProxies(array('1.1.1.1'));
        $request = Request::create('http://example.com', 'GET', array(), array(), array(), array(
            'HTTP_X_FORWARDED_PROTO' => 'https',
            'HTTP_X_FORWARDED_PORT' => '8443',
        ));
        $this->assertEquals(80, $request->getPort(), 'With PROTO and PORT on untrusted connection server value ta