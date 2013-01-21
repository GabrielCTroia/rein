<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Class: OAuth client</title>
</head>
<body>
<center><h1>Class: OAuth client</h1></center>
<hr />
<ul>
<p><b>Version:</b> <tt>@(#) $Id: oauth_client.php,v 1.37 2012/11/13 09:15:36 mlemos Exp $</tt></p>
<h2><a name="table_of_contents">Contents</a></h2>
<ul>
<li><a href="#2.1.1">Summary</a></li>
<ul>
<li><a href="#3.2.0">Name</a></li>
<li><a href="#3.2.0.0">Author</a></li>
<li><a href="#3.2.0.1">Copyright</a></li>
<li><a href="#3.2.0.2">Version</a></li>
<li><a href="#3.2.0.3">Purpose</a></li>
<li><a href="#3.2.0.4">Usage</a></li>
</ul>
<li><a href="#4.1.1">Variables</a></li>
<ul>
<li><a href="#5.2.26">error</a></li>
<li><a href="#5.2.27">debug</a></li>
<li><a href="#5.2.28">debug_http</a></li>
<li><a href="#5.2.29">exit</a></li>
<li><a href="#5.2.30">debug_output</a></li>
<li><a href="#5.2.31">debug_prefix</a></li>
<li><a href="#5.2.32">server</a></li>
<li><a href="#5.2.33">request_token_url</a></li>
<li><a href="#5.2.34">dialog_url</a></li>
<li><a href="#5.2.35">append_state_to_redirect_uri</a></li>
<li><a href="#5.2.36">access_token_url</a></li>
<li><a href="#5.2.37">oauth_version</a></li>
<li><a href="#5.2.38">url_parameters</a></li>
<li><a href="#5.2.39">authorization_header</a></li>
<li><a href="#5.2.40">redirect_uri</a></li>
<li><a href="#5.2.41">client_id</a></li>
<li><a href="#5.2.42">client_secret</a></li>
<li><a href="#5.2.43">scope</a></li>
<li><a href="#5.2.44">access_token</a></li>
<li><a href="#5.2.45">access_token_secret</a></li>
<li><a href="#5.2.46">access_token_expiry</a></li>
<li><a href="#5.2.47">access_token_type</a></li>
<li><a href="#5.2.48">access_token_error</a></li>
<li><a href="#5.2.49">authorization_error</a></li>
<li><a href="#5.2.50">response_status</a></li>
</ul>
<li><a href="#6.1.1">Functions</a></li>
<ul>
<li><a href="#7.2.9">StoreAccessToken</a></li>
<li><a href="#9.2.10">GetAccessToken</a></li>
<li><a href="#11.2.11">ResetAccessToken</a></li>
<li><a href="#11.2.12">CallAPI</a></li>
<li><a href="#13.2.13">Initialize</a></li>
<li><a href="#13.2.14">Process</a></li>
<li><a href="#13.2.15">Finalize</a></li>
<li><a href="#15.2.16">Output</a></li>
</ul>
</ul>
<p><a href="#table_of_contents">Top of the table of contents</a></p>
</ul>
<hr />
<ul>
<h2><li><a name="2.1.1">Summary</a></li></h2>
<ul>
<h3><a name="3.2.0">Name</a></h3>
<p>OAuth client</p>
<h3><a name="3.2.0.0">Author</a></h3>
<p>Manuel Lemos (<a href="mailto:mlemos-at-acm.org">mlemos-at-acm.org</a>)</p>
<h3><a name="3.2.0.1">Copyright</a></h3>
<p>Copyright &copy; (C) Manuel Lemos 2012</p>
<h3><a name="3.2.0.2">Version</a></h3>
<p>@(#) $Id: oauth_client.php,v 1.37 2012/11/13 09:15:36 mlemos Exp $</p>
<h3><a name="3.2.0.3">Purpose</a></h3>
<p>This class serves two main purposes:</p>
<p> 1) Implement the OAuth protocol to retrieve a token from a server to authorize the access to an API on behalf of the current user.</p>
<p> 2) Perform calls to a Web services API using a token previously obtained using this class or a token provided some other way by the Web services provider.</p>
<h3><a name="3.2.0.4">Usage</a></h3>
<p>Regardless of your purposes, you always need to start calling the class <tt><a href="#function_Initialize">Initialize</a></tt> function after initializing setup variables. After you are done with the class, always call the <tt><a href="#function_Finalize">Finalize</a></tt> function at the end.</p>
<p> This class supports either OAuth protocol versions 1.0, 1.0a and 2.0. It abstracts the differences between these protocol versions, so the class usage is the same independently of the OAuth version of the server.</p>
<p> The class also provides built-in support to several popular OAuth servers, so you do not have to manually configure all the details to access those servers. Just set the <tt><a href="#variable_server">server</a></tt> variable to configure the class to access one of the built-in supported servers.</p>
<p> If you need to access one type of server that is not yet directly supported by the class, you need to configure it explicitly setting the variables: <tt><a href="#variable_oauth_version">oauth_version</a></tt>, <tt><a href="#variable_url_parameters">url_parameters</a></tt>, <tt><a href="#variable_authorization_header">authorization_header</a></tt>, <tt><a href="#variable_request_token_url">request_token_url</a></tt>, <tt><a href="#variable_dialog_url">dialog_url</a></tt>, <tt><a href="#variable_append_state_to_redirect_uri">append_state_to_redirect_uri</a></tt> and <tt><a href="#variable_access_token_url">access_token_url</a></tt>.</p>
<p> Before proceeding to the actual OAuth authorization process, you need to have registered your application with the OAuth server. The registration provides you values to set the variables <tt><a href="#variable_client_id">client_id</a></tt> and  <tt><a href="#variable_client_secret">client_secret</a></tt>.</p>
<p> You also need to set the variables <tt><a href="#variable_redirect_uri">redirect_uri</a></tt> and <tt><a href="#variable_scope">scope</a></tt> before calling the <tt><a href="#function_Process">Process</a></tt> function to make the class perform the necessary interactions with the OAuth server.</p>
<p> The OAuth protocol involves multiple steps that include redirection to the OAuth server. There it asks permission to the current user to grant your application access to APIs on his/her behalf. When there is a redirection, the class will set the <tt><a href="#variable_exit">exit</a></tt> variable to 1. Then your script should exit immediately without outputting anything.</p>
<p> When the OAuth access token is successfully obtained, the following variables are set by the class with the obtained values: <tt><a href="#variable_access_token">access_token</a></tt>, <tt><a href="#variable_access_token_secret">access_token_secret</a></tt>, <tt><a href="#variable_access_token_expiry">access_token_expiry</a></tt>, <tt><a href="#variable_access_token_type">access_token_type</a></tt>. You may want to store these values to use them later when calling the server APIs.</p>
<p> If there was a problem during OAuth authorization process, check the variable <tt><a href="#variable_authorization_error">authorization_error</a></tt> to determine the reason.</p>
<p> Once you get the access token, you can call the server APIs using the <tt><a href="#function_CallAPI">CallAPI</a></tt> function. Check the <tt><a href="#variable_access_token_error">access_token_error</a></tt> variable to determine if there was an error when trying to to call the API.</p>
<p> If for some reason the user has revoked the access to your application, you need to ask the user to authorize your application again. First you may need to call the function <tt><a href="#function_ResetAccessToken">ResetAccessToken</a></tt> to reset the value of the access token that may be cached in session variables.</p>
<p><a href="#table_of_contents">Table of contents</a></p>
</ul>
</ul>
<hr />
<ul>
<h2><li><a name="variables"></a><a name="4.1.1">Variables</a></li></h2>
<ul>
<li><tt><a href="#variable_error">error</a></tt></li><br />
<li><tt><a href="#variable_debug">debug</a></tt></li><br />
<li><tt><a href="#variable_debug_http">debug_http</a></tt></li><br />
<li><tt><a href="#variable_exit">exit</a></tt></li><br />
<li><tt><a href="#variable_debug_output">debug_output</a></tt></li><br />
<li><tt><a href="#variable_debug_prefix">debug_prefix</a></tt></li><br />
<li><tt><a href="#variable_server">server</a></tt></li><br />
<li><tt><a href="#variable_request_token_url">request_token_url</a></tt></li><br />
<li><tt><a href="#variable_dialog_url">dialog_url</a></tt></li><br />
<li><tt><a href="#variable_append_state_to_redirect_uri">append_state_to_redirect_uri</a></tt></li><br />
<li><tt><a href="#variable_access_token_url">access_token_url</a></tt></li><br />
<li><tt><a href="#variable_oauth_version">oauth_version</a></tt></li><br />
<li><tt><a href="#variable_url_parameters">url_parameters</a></tt></li><br />
<li><tt><a href="#variable_authorization_header">authorization_header</a></tt></li><br />
<li><tt><a href="#variable_redirect_uri">redirect_uri</a></tt></li><br />
<li><tt><a href="#variable_client_id">client_id</a></tt></li><br />
<li><tt><a href="#variable_client_secret">client_secret</a></tt></li><br />
<li><tt><a href="#variable_scope">scope</a></tt></li><br />
<li><tt><a href="#variable_access_token">access_token</a></tt></li><br />
<li><tt><a href="#variable_access_token_secret">access_token_secret</a></tt></li><br />
<li><tt><a href="#variable_access_token_expiry">access_token_expiry</a></tt></li><br />
<li><tt><a href="#variable_access_token_type">access_token_type</a></tt></li><br />
<li><tt><a href="#variable_access_token_error">access_token_error</a></tt></li><br />
<li><tt><a href="#variable_authorization_error">authorization_error</a></tt></li><br />
<li><tt><a href="#variable_response_status">response_status</a></tt></li><br />
<p><a href="#table_of_contents">Table of contents</a></p>
<h3><a name="variable_error"></a><li><a name="5.2.26">error</a></li></h3>
<h3>Type</h3>
<p><tt><i>string</i></tt></p>
<h3>Default value</h3>
<p><tt>''</tt></p>
<h3>Purpose</h3>
<p>Store the message that is returned when an error occurs.</p>
<h3>Usage</h3>
<p>Check this variable to understand what happened when a call to any of the class functions has failed.</p>
<p> This class uses cumulative error handling. This means that if one class functions that may fail is called and this variable was already set to an error message due to a failure in a previous call to the same or other function, the function will also fail and does not do anything.</p>
<p> This allows programs using this class to safely call several functions that may fail and only check the failure condition after the last function call.</p>
<p> Just set this variable to an empty string to clear the error condition.</p>
<p><a href="#variables">Variables</a></p>
<h3><a name="variable_debug"></a><li><a name="5.2.27">debug</a></li></h3>
<h3>Type</h3>
<p><tt><i>bool</i></tt></p>
<h3>Default value</h3>
<p><tt>0</tt></p>
<h3>Purpose</h3>
<p>Control whether debug output is enabled</p>
<h3>Usage</h3>
<p>Set this variable to 1 if you need to check what is going on during calls to the class. When enabled, the debug output goes either to the variable <tt><a href="#variable_debug_output">debug_output</a></tt> and the PHP error log.</p>
<p><a href="#variables">Variables</a></p>
<h3><a name="variable_debug_http"></a><li><a name="5.2.28">debug_http</a></li></h3>
<h3>Type</h3>
<p><tt><i>bool</i></tt></p>
<h3>Default value</h3>
<p><tt>0</tt></p>
<h3>Purpose</h3>
<p>Control whether the dialog with the remote Web server should also be logged.</p>
<h3>Usage</h3>
<p>Set this variable to 1 if you want to inspect the data exchange with the OAuth server.</p>
<p><a href="#variables">Variables</a></p>
<h3><a name="variable_exit"></a><li><a name="5.2.29">exit</a></li></h3>
<h3>Type</h3>
<p><tt><i>bool</i></tt></p>
<h3>Default value</h3>
<p><tt>0</tt></p>
<h3>Purpose</h3>
<p>Determine if the current script should be exited.</p>
<h3>Usage</h3>
<p>Check this variable after calling the <tt><a href="#function_Process">Process</a></tt> function and exit your script immediately if the variable is set to 1.</p>
<p><a href="#variables">Variables</a></p>
<h3><a name="variable_debug_output"></a><li><a name="5.2.30">debug_output</a></li></h3>
<h3>Type</h3>
<p><tt><i>string</i></tt></p>
<h3>Default value</h3>
<p><tt>''</tt></p>
<h3>Purpose</h3>
<p>Capture the debug output generated by the class</p>
<h3>Usage</h3>
<p>Inspect this variable if you need to see what happened during the class function calls.</p>
<p><a href="#variables">Variables</a></p>
<h3><a name="variable_debug_prefix"></a><li><a name="5.2.31">debug_prefix</a></li></h3>
<h3>Type</h3>
<p><tt><i>string</i></tt></p>
<h3>Default value</h3>
<p><tt>'OAuth client: '</tt></p>
<h3>Purpose</h3>
<p>Mark the lines of the debug output to identify actions performed by this class.</p>
<h3>Usage</h3>
<p>Change this variable if you prefer the debug output lines to be prefixed with a different text.</p>
<p><a href="#variables">Variables</a></p>
<h3><a name="variable_server"></a><li><a name="5.2.32">server</a></li></h3>
<h3>Type</h3>
<p><tt><i>string</i></tt></p>
<h3>Default value</h3>
<p><tt>''</tt></p>
<h3>Purpose</h3>
<p>Identify the type of OAuth server to access.</p>
<h3>Usage</h3>
<p>The class provides built-in support to several types of OAuth servers. This means that the class can automatically initialize several configuration variables just by setting this server variable.</p>
<p> Currently it supports the following servers: 'Facebook', 'Flickr', 'Foursquare', 'github', 'Google', 'Microsoft', 'Tumblr', 'Twitter' and 'Yahoo'. Please contact the author if you would like to ask to add built-in support for other types of OAuth servers.</p>
<p> If you want to access other types of OAuth servers that are not yet supported, set this variable to an empty string and configure other variables with values specific to those servers.</p>
<p><a href="#variables">Variables</a></p>
<h3><a name="variable_request_token_url"></a><li><a name="5.2.33">request_token_url</a></li></h3>
<h3>Type</h3>
<p><tt><i>string</i></tt></p>
<h3>Default value</h3>
<p><tt>''</tt></p>
<h3>Purpose</h3>
<p>URL of the OAuth server to request the initial token for OAuth 1.0 and 1.0a servers.</p>
<h3>Usage</h3>
<p>Set this variable to the OAuth request token URL when you are not accessing one of the built-in supported OAuth servers.</p>
<p><a href="#variables">Variables</a></p>
<h3><a name="variable_dialog_url"></a><li><a name="5.2.34">dialog_url</a></li></h3>
<h3>Type</h3>
<p><tt><i>string</i></tt></p>
<h3>Default value</h3>
<p><tt>''</tt></p>
<h3>Purpose</h3>
<p>URL of the OAuth server to redirect the browser so the user can grant access to your application.</p>
<h3>Usage</h3>
<p>Set this variable to the OAuth request token URL when you are not accessing one of the built-in supported OAuth servers.</p>
<p> For OAuth 2.0 servers, the dialog URL can have certain marks that will act as template placeholders that will be replaced with values defined before redirecting the users browser. Currently it supports the following placeholder marks:</p>
<p> {REDIRECT_URI} - URL to redirect when returning from the OAuth server authorization page</p>
<p> {CLIENT_ID} - client application identifier registered at the server</p>
<p> {SCOPE} - scope of the requested permissions to the granted by the OAuth server with the user permission</p>
<p> {STATE} - identifier of the OAuth session state</p>
<p><a href="#variables">Variables</a></p>
<h3><a name="variable_append_state_to_redirect_uri"></a><li><a name="5.2.35">append_state_to_redirect_uri</a></li></h3>
<h3>Type</h3>
<p><tt><i>string</i></tt></p>
<h3>Default value</h3>
<p><tt>''</tt></p>
<h3>Purpose</h3>
<p>Pass the OAuth session state in a variable with a different name to work around implementation bugs of certain OAuth servers</p>
<h3>Usage</h3>
<p>Set this variable  when you are not accessing one of the built-in supported OAuth servers if the OAuth server has a bug that makes it not pass back the OAuth state identifier in a request variable named state.</p>
<p><a href="#variables">Variables</a></p>
<h3><a name="variable_access_token_url"></a><li><a name="5.2.36">access_token_url</a></li></h3>
<h3>Type</h3>
<p><tt><i>string</i></tt></p>
<h3>Default value</h3>
<p><tt>''</tt></p>
<h3>Purpose</h3>
<p>OAuth server URL that will return the access token URL.</p>
<h3>Usage</h3>
<p>Set this variable to the OAuth access token URL when you are not accessing one of the built-in supported OAuth servers.</p>
<p><a href="#variables">Variables</a></p>
<h3><a name="variable_oauth_version"></a><li><a name="5.2.37">oauth_version</a></li></h3>
<h3>Type</h3>
<p><tt><i>string</i></tt></p>
<h3>Default value</h3>
<p><tt>'2.0'</tt></p>
<h3>Purpose</h3>
<p>Version of the protocol version supported by the OAuth server.</p>
<h3>Usage</h3>
<p>Set this variable to the OAuth server protocol version when you are not accessing one of the built-in supported OAuth servers.</p>
<p><a href="#variables">Variables</a></p>
<h3><a name="variable_url_parameters"></a><li><a name="5.2.38">url_parameters</a></li></h3>
<h3>Type</h3>
<p><tt><i>bool</i></tt></p>
<h3>Default value</h3>
<p><tt>0</tt></p>
<h3>Purpose</h3>
<p>Determine if the API call parameters should be moved to the call URL.</p>
<h3>Usage</h3>
<p>Set this variable to 1 if the API you need to call requires that the call parameters always be passed via the API URL.</p>
<p><a href="#variables">Variables</a></p>
<h3><a name="variable_authorization_header"></a><li><a name="5.2.39">authorization_header</a></li></h3>
<h3>Type</h3>
<p><tt><i>bool</i></tt></p>
<h3>Default value</h3>
<p><tt>1</tt></p>
<h3>Purpose</h3>
<p>Determine if the OAuth parameters should be passed via HTTP Authorization request header.</p>
<h3>Usage</h3>
<p>Set this variable to 1 if the OAuth server requires that the OAuth parameters be passed using the HTTP Authorization instead of the request URI parameters.</p>
<p><a href="#variables">Variables</a></p>
<h3><a name="variable_redirect_uri"></a><li><a name="5.2.40">redirect_uri</a></li></h3>
<h3>Type</h3>
<p><tt><i>string</i></tt></p>
<h3>Default value</h3>
<p><tt>''</tt></p>
<h3>Purpose</h3>
<p>URL of the current script page that is calling this class</p>
<h3>Usage</h3>
<p>Set this variable to the current script page URL before proceeding the the OAuth authorization process.</p>
<p><a href="#variables">Variables</a></p>
<h3><a name="variable_client_id"></a><li><a name="5.2.41">client_id</a></li></h3>
<h3>Type</h3>
<p><tt><i>string</i></tt></p>
<h3>Default value</h3>
<p><tt>''</tt></p>
<h3>Purpose</h3>
<p>Identifier of your application registered with the OAuth server</p>
<h3>Usage</h3>
<p>Set this variable to the application identifier that is provided by the OAuth server when you register the application.</p>
<p><a href="#variables">Variables</a></p>
<h3><a name="variable_client_secret"></a><li><a name="5.2.42">client_secret</a></li></h3>
<h3>Type</h3>
<p><tt><i>string</i></tt></p>
<h3>Default value</h3>
<p><tt>''</tt></p>
<h3>Purpose</h3>
<p>Secret value assigned to your application when it is registered with the OAuth server.</p>
<h3>Usage</h3>
<p>Set this variable to the application secret that is provided by the OAuth server when you register the application.</p>
<p><a href="#variables">Variables</a></p>
<h3><a name="variable_scope"></a><li><a name="5.2.43">scope</a></li></h3>
<h3>Type</h3>
<p><tt><i>string</i></tt></p>
<h3>Default value</h3>
<p><tt>''</tt></p>
<h3>Purpose</h3>
<p>Permissions that your application needs to call the OAuth server APIs</p>
<h3>Usage</h3>
<p>Check the documentation of the APIs that your application needs to call to set this variable with the identifiers of the permissions that the user needs to grant to your application.</p>
<p><a href="#variables">Variables</a></p>
<h3><a name="variable_access_token"></a><li><a name="5.2.44">access_token</a></li></h3>
<h3>Type</h3>
<p><tt><i>string</i></tt></p>
<h3>Default value</h3>
<p><tt>''</tt></p>
<h3>Purpose</h3>
<p>Access token obtained from the OAuth server</p>
<h3>Usage</h3>
<p>Check this variable to get the obtained access token upon successful OAuth authorization.</p>
<p><a href="#variables">Variables</a></p>
<h3><a name="variable_access_token_secret"></a><li><a name="5.2.45">access_token_secret</a></li></h3>
<h3>Type</h3>
<p><tt><i>string</i></tt></p>
<h3>Default value</h3>
<p><tt>''</tt></p>
<h3>Purpose</h3>
<p>Access token secret obtained from the OAuth server</p>
<h3>Usage</h3>
<p>If the OAuth protocol version is 1.0 or 1.0a, check this variable to get the obtained access token secret upon successful OAuth authorization.</p>
<p><a href="#variables">Variables</a></p>
<h3><a name="variable_access_token_expiry"></a><li><a name="5.2.46">access_token_expiry</a></li></h3>
<h3>Type</h3>
<p><tt><i>string</i></tt></p>
<h3>Default value</h3>
<p><tt>''</tt></p>
<h3>Purpose</h3>
<p>Timestamp of the expiry of the access token obtained from the OAuth server.</p>
<h3>Usage</h3>
<p>Check this variable to get the obtained access token expiry time upon successful OAuth authorization. If this variable is empty, that means no expiry time was set.</p>
<p><a href="#variables">Variables</a></p>
<h3><a name="variable_access_token_type"></a><li><a name="5.2.47">access_token_type</a></li></h3>
<h3>Type</h3>
<p><tt><i>string</i></tt></p>
<h3>Default value</h3>
<p><tt>''</tt></p>
<h3>Purpose</h3>
<p>Type of access token obtained from the OAuth server.</p>
<h3>Usage</h3>
<p>Check this variable to get the obtained access token type upon successful OAuth authorization.</p>
<p><a href="#variables">Variables</a></p>
<h3><a name="variable_access_token_error"></a><li><a name="5.2.48">access_token_error</a></li></h3>
<h3>Type</h3>
<p><tt><i>string</i></tt></p>
<h3>Default value</h3>
<p><tt>''</tt></p>
<h3>Purpose</h3>
<p>Error message returned when a call to the API fails.</p>
<h3>Usage</h3>
<p>Check this variable to determine if there was an error while calling the Web services API when using the <tt><a href="#function_CallAPI">CallAPI</a></tt> function.</p>
<p><a href="#variables">Variables</a></p>
<h3><a name="variable_authorization_error"></a><li><a name="5.2.49">authorization_error</a></li></h3>
<h3>Type</h3>
<p><tt><i>string</i></tt></p>
<h3>Default value</h3>
<p><tt>''</tt></p>
<h3>Purpose</h3>
<p>Error message returned when it was not possible to obtain an OAuth access token</p>
<h3>Usage</h3>
<p>Check this variable to determine if there was an error while trying to obtain the OAuth access token.</p>
<p><a href="#variables">Variables</a></p>
<h3><a name="variable_response_status"></a><li><a name="5.2.50">response_status</a></li></h3>
<h3>Type</h3>
<p><tt><i>int</i></tt></p>
<h3>Default value</h3>
<p><tt>0</tt></p>
<h3>Purpose</h3>
<p>HTTP response status returned by the server when calling an API</p>
<h3>Usage</h3>
<p>Check this variable after calling the <tt><a href="#function_CallAPI">CallAPI</a></tt> function if the API calls and you need to process the error depending the response status. 200 means no error.  0 means the server response was not retrieved.</p>
<p><a href="#variables">Variables</a></p>
<p><a href="#table_of_contents">Table of contents</a></p>
</ul>
</ul>
<hr />
<ul>
<h2><li><a name="functions"></a><a name="6.1.1">Functions</a></li></h2>
<ul>
<li><tt><a href="#function_StoreAccessToken">StoreAccessToken</a></tt></li><br />
<li><tt><a href="#function_GetAccessToken">GetAccessToken</a></tt></li><br />
<li><tt><a href="#function_ResetAccessToken">ResetAccessToken</a></tt></li><br />
<li><tt><a href="#function_CallAPI">CallAPI</a></tt></li><br />
<li><tt><a href="#function_Initialize">Initialize</a></tt></li><br />
<li><tt><a href="#function_Process">Process</a></tt></li><br />
<li><tt><a href="#function_Finalize">Finalize</a></tt></li><br />
<li><tt><a href="#function_Output">Output</a></tt></li><br />
<p><a href="#table_of_contents">Table of contents</a></p>
<h3><a name="function_StoreAccessToken"></a><li><a name="7.2.9">StoreAccessToken</a></li></h3>
<h3>Synopsis</h3>
<p><tt><i>bool</i> StoreAccessToken(</tt><ul>
<tt>(input and output) <i>array</i> </tt><tt><a href="#argument_StoreAccessToken_access_token">access_token</a></tt></ul>
<tt>)</tt></p>
<h3>Purpose</h3>
<p>Store the values of the access token when it is succefully retrieved from the OAuth server.</p>
<h3>Usage</h3>
<p>This function is meant to be only be called from inside the class. By default it stores access tokens in a session variable named 'OAUTH_ACCESS_TOKEN'.</p>
<p> Actual implementations should create a sub-class and override this function to make the access token values be stored in other types of containers, like for instance databases.</p>
<h3>Arguments</h3>
<ul>
<p><tt><b><a name="argument_StoreAccessToken_access_token">access_token</a></b></tt> - Associative array with properties of the access token.  The array may have set the following properties:</p>
<p> 'value': string value of the access token</p>
<p> 'authorized': boolean value that determines if the access token was obtained successfully</p>
<p> 'expiry': (optional) timestamp in ISO format relative to UTC time zone of the access token expiry time</p>
<p> 'type': (optional) type of OAuth token that may determine how it should be used when sending API call requests.</p>
</ul>
<h3>Return value</h3>
<p>This function should return 1 if the access token was stored successfully.</p>
<p><a href="#functions">Functions</a></p>
<h3><a name="function_GetAccessToken"></a><li><a name="9.2.10">GetAccessToken</a></li></h3>
<h3>Synopsis</h3>
<p><tt><i>bool</i> GetAccessToken(</tt><ul>
<tt>(output) <i>string &amp;</i> </tt><tt><a href="#argument_GetAccessToken_access_token">access_token</a></tt></ul>
<tt>)</tt></p>
<h3>Purpose</h3>
<p>Retrieve the OAuth access token if it was already previously stored by the <tt><a href="#function_StoreAccessToken">StoreAccessToken</a></tt> function.</p>
<h3>Usage</h3>
<p>This function is meant to be only be called from inside the class. By default it retrieves access tokens stored in a session variable named 'OAUTH_ACCESS_TOKEN'.</p>
<p> Actual implementations should create a sub-class and override this function to retrieve the access token values from other types of containers, like for instance databases.</p>
<h3>Arguments</h3>
<ul>
<p><tt><b><a name="argument_GetAccessToken_access_token">access_token</a></b></tt> - Return the properties of the access token in an associative array. If the access token was not yet stored, it returns an empty array. Otherwise, the properties it may return are the same that may be passed to the <tt><a href="#function_StoreAccessToken">StoreAccessToken</a></tt>.</p>
</ul>
<h3>Return value</h3>
<p>This function should return 1 if the access token was retrieved successfully.</p>
<p><a href="#functions">Functions</a></p>
<h3><a name="function_ResetAccessToken"></a><li><a name="11.2.11">ResetAccessToken</a></li></h3>
<h3>Synopsis</h3>
<p><tt><i>bool</i> ResetAccessToken(</tt><tt>)</tt></p>
<h3>Purpose</h3>
<p>Reset the access token to a state back when the user has not yet authorized the access to the OAuth server API.</p>
<h3>Usage</h3>
<p>Call this function if for some reason the token to access the API was revoked and you need to ask the user to authorize the access again.</p>
<p> By default the class stores and retrieves access tokens in a session variable named 'OAUTH_ACCESS_TOKEN'.</p>
<p> This function must be called when the user is accessing your site pages, so it can reset the information stored in session variables that cache the state of a previously retrieved access token.</p>
<p> Actual implementations should create a sub-class and override this function to reset the access token state when it is stored in other types of containers, like for instance databases.</p>
<h3>Return value</h3>
<p>This function should return 1 if the access token was resetted successfully.</p>
<p><a href="#functions">Functions</a></p>
<h3><a name="function_CallAPI"></a><li><a name="11.2.12">CallAPI</a></li></h3>
<h3>Synopsis</h3>
<p><tt><i>bool</i> CallAPI(</tt><ul>
<tt><i>string</i> </tt><tt><a href="#argument_CallAPI_url">url</a></tt><tt>,</tt><br />
<tt><i>string</i> </tt><tt><a href="#argument_CallAPI_method">method</a></tt><tt>,</tt><br />
<tt>(input and output) <i>array</i> </tt><tt><a href="#argument_CallAPI_parameters">parameters</a></tt><tt>,</tt><br />
<tt>(input and output) <i>array</i> </tt><tt><a href="#argument_CallAPI_options">options</a></tt><tt>,</tt><br />
<tt>(output) <i>string &amp;</i> </tt><tt><a href="#argument_CallAPI_response">response</a></tt></ul>
<tt>)</tt></p>
<h3>Purpose</h3>
<p>Send a HTTP request to the Web services API using a previously obtained authorization token via OAuth.</p>
<h3>Usage</h3>
<p>This function can be used to call an API after having previously obtained an access token through the OAuth protocol using the <tt><a href="#function_Process">Process</a></tt> function, or by directly setting the variables <tt><a href="#variable_access_token">access_token</a></tt>, as well as <tt><a href="#variable_access_token_secret">access_token_secret</a></tt> in case of using OAuth 1.0 or 1.0a services.</p>
<h3>Arguments</h3>
<ul>
<p><tt><b><a name="argument_CallAPI_url">url</a></b></tt> - URL of the API where the HTTP request will be sent.</p>
<p><tt><b><a name="argument_CallAPI_method">method</a></b></tt> - HTTP method that will be used to send the request. It can be 'GET', 'POST', 'DELETE', 'PUT', etc..</p>
<p><tt><b><a name="argument_CallAPI_parameters">parameters</a></b></tt> - Associative array with the names and values of the API call request parameters.</p>
<p><tt><b><a name="argument_CallAPI_options">options</a></b></tt> - Associative array with additional options to configure the request. Currently it supports the following options:</p>
<p> 'Resource': string with a label that will be used in the error messages and debug log entries to identify what operation the request is performing. The default value is 'API call'.</p>
<p> 'ConvertObjects': boolean option that determines if objects should be converted into arrays when the response is returned in JSON format. The default value is 0.</p>
<p> 'FailOnAccessError': boolean option that determines if this functions should fail when the server response status is not 200. The default value is 0.</p>
<p> 'RequestContentType': content type that should be used to send the request values. It can be either 'application/x-www-form-urlencoded' for sending values like from Web forms, or 'application/json' for sending the values encoded in JSON format. The default value is 'application/x-www-form-urlencoded'.</p>
<p><tt><b><a name="argument_CallAPI_response">response</a></b></tt> - Return the value of the API response. If the value is JSON encoded, this function will decode it and return the value converted to respective types. If the value is form encoded, this function will decode the response and return it as an array. Otherwise, the class will return the value as a string.</p>
</ul>
<h3>Return value</h3>
<p>This function returns 1 if the call was done successfully.</p>
<p><a href="#functions">Functions</a></p>
<h3><a name="function_Initialize"></a><li><a name="13.2.13">Initialize</a></li></h3>
<h3>Synopsis</h3>
<p><tt><i>bool</i> Initialize(</tt><tt>)</tt></p>
<h3>Purpose</h3>
<p>Initialize the class variables and internal state. It must be called before calling other class functions.</p>
<h3>Usage</h3>
<p>Set the <tt><a href="#variable_server">server</a></tt> variable before calling this function to let it initialize the class variables to work with the specified server type. Alternatively, you can set other class variables manually to make it work with servers that are not yet built-in supported.</p>
<h3>Return value</h3>
<p>This function returns 1 if it was able to successfully initialize the class for the specified server type.</p>
<p><a href="#functions">Functions</a></p>
<h3><a name="function_Process"></a><li><a name="13.2.14">Process</a></li></h3>
<h3>Synopsis</h3>
<p><tt><i>bool</i> Process(</tt><tt>)</tt></p>
<h3>Purpose</h3>
<p>Process the OAuth protocol interaction with the OAuth server.</p>
<h3>Usage</h3>
<p>Call this function when you need to retrieve the OAuth access token. Check the <tt><a href="#variable_access_token">access_token</a></tt> to determine if the access token was obtained successfully.</p>
<h3>Return value</h3>
<p>This function returns 1 if the OAuth protocol was processed without errors.</p>
<p><a href="#functions">Functions</a></p>
<h3><a name="function_Finalize"></a><li><a name="13.2.15">Finalize</a></li></h3>
<h3>Synopsis</h3>
<p><tt><i>bool</i> Finalize(</tt><ul>
<tt><i>bool</i> </tt><tt><a href="#argument_Finalize_success">success</a></tt></ul>
<tt>)</tt></p>
<h3>Purpose</h3>
<p>Cleanup any resources that may have been used during the OAuth protocol processing or execution of API calls.</p>
<h3>Usage</h3>
<p>Always call this function as the last step after calling the functions <tt><a href="#function_Process">Process</a></tt> or <tt><a href="#function_CallAPI">CallAPI</a></tt>.</p>
<h3>Arguments</h3>
<ul>
<p><tt><b><a name="argument_Finalize_success">success</a></b></tt> - Pass the last success state returned by the class or any external code processing the class function results.</p>
</ul>
<h3>Return value</h3>
<p>This function returns 1 if the function cleaned up any resources successfully.</p>
<p><a href="#functions">Functions</a></p>
<h3><a name="function_Output"></a><li><a name="15.2.16">Output</a></li></h3>
<h3>Synopsis</h3>
<p><tt><i></i> Output(</tt><tt>)</tt></p>
<h3>Purpose</h3>
<p>Display the results of the OAuth protocol processing.</p>
<h3>Usage</h3>
<p>Only call this function if you are debugging the OAuth authorization process and you need to view what was its results.</p>
<p><a href="#functions">Functions</a></p>
<p><a href="#table_of_contents">Table of contents</a></p>
</ul>
</ul>

<hr />
<address>Manuel Lemos (<a href="mailto:mlemos-at-acm.org">mlemos-at-acm.org</a>)</address>
</body>
</html>
