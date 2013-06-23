Copyright (C) 2011 by Kris

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.

About
	Bitcoin payment via BIPS for OpenCart.

Version 0.1
	Currency convert between all currencies automatically.
	
System Requirements:
	BIPS account
	Opencart v1.5.5.1 or lower
	PHP 5+
	Curl PHP Extension
  
Configuration Instructions:
	1. Upload files to your OpenCart installation.
	2. Go to your OpenCart administration. Extensions -> Payments -> "BIPS" click [Install]
	3. Go to your OpenCart administration. Extensions -> Payments -> "BIPS" click [Edit]
	4. In BIPS Callback URL (https://bips.me/merchant) Enter the link to your callback of BIPS OpenCart Payment Module. (http://YOUR_OPENCART_URL/index.php?route=payment/walletbit/callback)
	5. Enter a strong Secret in Merchant SECRET.
	6. In module settings "API" <- set your BIPS API Key, which can be generate under API Keys, Invoice.
	7. In module settings "Secret" <- Enter your BIPS Merchant Secret.