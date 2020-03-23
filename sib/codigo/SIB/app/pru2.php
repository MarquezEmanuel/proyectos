<?php
// mydap version 3
// https://samjlevy.com/mydap/
 
function mydap_start($host,$username,$password) {
	global $mydap;
	if(isset($mydap)) die('Error, LDAP connection already established');
 
	// Connect to AD
	$mydap = ldap_connect($host) or die('Error connecting to LDAP');
	@ldap_bind($mydap,$username,$password) or die('Error binding to LDAP: '.ldap_error($mydap));
 
	return true;
}
 
function mydap_end() {
	global $mydap;
	if(!isset($mydap)) die('Error, no LDAP connection established');
 
	// Close existing LDAP connection
	ldap_unbind($mydap);
}
 
function mydap_attributes($user,$keep=false) {
	global $mydap;
	if(!isset($mydap)) die('Error, no LDAP connection established');
	if(empty($user)) die('Error, no LDAP user specified');
 
 	// Query user attributes
 	$results = ldap_search($mydap,$user,'sn=*',$keep) or die('Error searching LDAP: '.ldap_error($mydap));
	$attributes = ldap_get_entries($mydap, $results);
 
	// Return attributes list
	return $attributes[0];
}
 
function mydap_members($group) {
	global $mydap;
	if(!isset($mydap)) die('Error, no LDAP connection established');
	if(empty($group)) die('Error, no LDAP group specified');
 
	// Query group members
	$results = ldap_search($mydap,$group,'cn=*',array('member')) or die('Error searchinggg LDAP: '.ldap_error($mydap));
	$members = ldap_get_entries($mydap, $results);
 
	if(!isset($members[0]['member'])) return false;
 
	// Remove 'count' element from array
	array_shift($members[0]['member']);
 
	// Return member list
	return $members[0]['member'];
}
 
// ==================================================================================
// Example Usage
// ==================================================================================
 
// Establish connection
mydap_start(
	'DCBSC0010.santacruz.net', // Active Directory server
	'SANTACRUZ\svpprod', // Active Directory search user
	'FME168qu' // Active Directory search user password
);
 
// Get members of our group by providing dn
$members = mydap_members('CN=Big Wigs,OU=Test Groups,DC=ad,DC=local');
if(!$members) die('No group members found');
 
// Here you could pull another group's members by running myldap_members again
// And merge the results with the previous results, or whatever you need
// ...
 
// User attributes we want to obtain
$keep = array('displayname','samaccountname');
 
// Iterate each member to get attributes
foreach($members as $m) {
	$attr = mydap_attributes($m,$keep);
 
	// Do what you will, such as store or display member information
	echo "{$attr['displayname'][0]}, {$attr['samaccountname'][0]}<br>";
}
 
// Close connection
mydap_end();
 
// Here you could open a new connection to a different AD server if needed
// ...
?>