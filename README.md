## SCTMiddleware
Data driven middleware.

<b>Developed By</b>
<p>Ikram - Ud - Daula</p>
<p>Software Developer, SCT-Technology GmbH</p><br>

<b>Documentation</b> 
<p>Create an object of SCTMiddleware class</p>
<pre>$obj = new SCTMiddleware;
</pre>

<b>setKey and setKeys function:</b>
<pre>
setKey('oldKey', 'newKey');</br>
setKeys($array);
</pre>
<b>process and reprocess function:</b>
<pre>
process($array);</br>
reprocess($array);
</pre>
<b>Get processed data called a function named response()</b>

Say for you data:
<pre>
$rows = array(
  [0] = array (
    [id] = 001
    [name] = Kevin Doe
  )
  [1] = array (
    [id] = 002
    [name] = John Doe
  )
);
</pre>
set key property which you want.
example: <pre>$obj->setKey('id', 'serial_no');</pre>
Or you may an array for keys: 
<pre>
$array = [
  'id' => 'serial_no',
  'name' => 'fullname'
];
</pre>
<b>process</b> 
<pre>$obj->setKeys($array);
$obj->process($rows);
print_r($obj->response());
</pre>
<b>Output:</b>
<pre>
$rows = array(
  [0] = array (
    [serial_no] = 001
    [fullname] = Kevin Doe
  )
  [1] = array (
    [serial_no] = 002
    [fullname] = John Doe
  )
);
</pre>
<b>reprocess:</b>
<pre>
$obj->reprocess(process result);
print_r($obj->response());
</pre>
<b>Output:</b>
<pre>
$rows = array(
  [0] = array (
    [id] = 001
    [name] = Kevin Doe
  )
  [1] = array (
    [id] = 002
    [name] = John Doe
  )
);
</pre>
<p>
<b>process and reprocess function:</b>
It’s contained two parameter. Second parameter by default <b>false</b>. 
If you send it <b>true</b> then process function return only changed index array otherwise it’s return all of index array. 
Similar action for <b>reprocess</b> function. 
</p>
