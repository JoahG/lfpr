<?php

$_ROUTES = array();


$_ROUTES[] = array("root_path" => array("url" => "/", "controller" => "Home", "action" => "index"));
/*
$_ROUTES[] = array(
	"login" => array("url" => "/login", "controller" => "Login", "action" => "index"),
	"sign_in" => array("url" => "/login/sign_in", "controller" => "Login", "action" => "signIn", "via" => "post"),
	"sign_out" => array("url" => "/login/sign_out", "controller" => "Login", "action" => "signOut", "via" => "post")
	);
*/
$_ROUTES[] = array(
	"list" => array("url" => "/project/", "controller" => "Project", "action" => "index"),
	"create" => array("url" => "/project/create", "controller" => "Project", "action" => "create", "via" => "post"),
	"grab_data" => array("url" => "/project/grab_data", "controller" => "Project", "action" => "grab_data", "via" => "post"),
	"new" => array("url" => "/project/new", "controller" => "Project", "action" => "new"),
	"show" => array("url" => "/project/:id", "controller" => "Project", "action" => "show", "via" => "get"),
	"update" => array("url" => "/project/:id/edit", "controller" => "Project", "action" => "edit"),
	"delete" => array("url" => "/project/:id/delete", "controller" => "Project", "action" => "delete", "via" => "post")
	); $_ROUTES[] = array(
	"list" => array("url" => "/developer/", "controller" => "Developer", "action" => "index"),
	"create" => array("url" => "/developer/create", "controller" => "Developer", "action" => "create", "via" => "post"),
	"new" => array("url" => "/developer/new", "controller" => "Developer", "action" => "new"),
	"retrieve" => array("url" => "/developer/:id", "controller" => "Developer", "action" => "show", "via" => "get"),
	"update" => array("url" => "/developer/:id/edit", "controller" => "Developer", "action" => "edit"),
	"delete" => array("url" => "/developer/:id/delete", "controller" => "Developer", "action" => "delete", "via" => "post")
	); $_ROUTES[] = array(
	"list" => array("url" => "/suscriptor/", "controller" => "Suscriptor", "action" => "index"),
	"create" => array("url" => "/suscriptor/create", "controller" => "Suscriptor", "action" => "create", "via" => "post"),
	"delete" => array("url" => "/suscriptor/:id/delete", "controller" => "Suscriptor", "action" => "delete", "via" => "post")
	); 
	$_ROUTES[] = array(
	"generate" => array("url" => "/project_delta/gen", "controller" => "ProjectDelta", "action" => "generate"),
	/*
	"list" => array("url" => "/project_delta/", "controller" => "ProjectDelta", "action" => "index"),
	"create" => array("url" => "/project_delta/create", "controller" => "ProjectDelta", "action" => "create", "via" => "post"),
	"new" => array("url" => "/project_delta/new", "controller" => "ProjectDelta", "action" => "new"),
	"retrieve" => array("url" => "/project_delta/:id", "controller" => "ProjectDelta", "action" => "show", "via" => "get"),
	"update" => array("url" => "/project_delta/:id/edit", "controller" => "ProjectDelta", "action" => "edit"),
	"delete" => array("url" => "/project_delta/:id/delete", "controller" => "ProjectDelta", "action" => "delete", "via" => "post")
	*/);

	 ?>