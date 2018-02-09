## SCTMiddleware
Data driven middleware.

#Documentation 
Create an object of SCTMiddleware class

#setKey and setKeys function:
setKey('oldKey', 'newKey');
setKeys($array);

#processing and reprocess function:
processing($array);
reprocess($array);

#Get processing data called a function named response()

Say for you data:
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

set key property which you want.
example: $obj->setKey('id', 'serial_no');
Or you may an array for keys: 
$array = [
  'id' => 'serial_no',
  'name' => 'fullname'
];

Then $obj->setKeys($array);
$obj->processing($rows);
echo '<pre>';
print_r($obj->response());

Output:
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

#reprocess:
$obj->reprocess(processing result);
echo '<pre>';
print_r($obj->response());

Output:
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
