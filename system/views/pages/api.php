<?php
require( DIR_VIEWS . '/header.php' );
require( DIR_VIEWS . '/widgets/navigation.php' );
?>

<h1>Location Locator Admin API</h1>

<p><strong>If an error occurs a status other than 200 will be returned along with a message describing the error.</strong></p>

<h2>GET api/geocode<span>Geocode a location</span></h2>
<h4>Parameters</h4>
<p>Parameters depend upon the table column names</p>
<p>In your config file you'll see a config option <em>$config['geocode_string']</em>.  This config option should contain the columns of your table that are used to geocode the location. Those columns that are used for geocoding at the columns that are required by <em>api/geocode</em>.
<p><strong>For Example:</strong></p>
<p>The sample data located in <em>system/extras/create_table.sql</em> uses the table columns address, city, state. These three parameters would be required.</p>

<hr>

<h2>POST api/edit/:id<span>Edit a location's details</span></h2>
<h4>Parameters</h4>
<dl class="parameter_list">
	<dt>:id</dt>
	<dd>ID of the locationto edit</dd>
</dl>
<p>All other locationproperties are optional. If you include a locationproperty, it will be updated to the supplied value.</p>


<hr>

<h2>POST api/delete/:id<span>Delete a location</span></h2>
<h4>Parameters</h4>
<dl class="parameter_list">
	<dt>:id</dt>
	<dd>ID of the locationto delete</dd>
</dl>

<hr>

<h2>GET api/get/:id<span>Retreive a location</span></h2>
<h4>Parameters</h4>
<dl class="parameter_list">
	<dt>:id</dt>
	<dd>ID of the locationto retreive</dd>
</dl>
<p>Returns a location</p>

<hr>

<h2>POST api/create/<span>Create a location</span></h2>
<h4>Parameters</h4>
<p>Parameters depend upon the table column names</p>
<p>The supplied POST data will be used to create the location.</p>

<?php
require( DIR_VIEWS . '/footer.php' );
?>