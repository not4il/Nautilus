<?php

    if(isset($_POST['todo'])) {
        switch($_POST['todo']) {
            case "tryConnect":
                if(isset($_POST['application'],$_POST['license'])) {
                    if(file_exists(dirname(__FILE__,2).'/apps/'.$_POST['application'].'/app.json')) {
				        $keys=json_decode(file_get_contents(dirname(__FILE__,2).'/apps/'.$_POST['application'].'/keys.json'),true);
				        if(isset($keys[$_POST['license']])) {
				            if(password_verify(md5(base64_decode($_POST['license'])),$keys[$_POST['license']]['hash'])) {
				                if($keys[$_POST['license']]['active'] == TRUE) {
				                    if($keys[$_POST['license']]['connected'] < $keys[$_POST['license']]['devices']) {
				                        $keys[$_POST['license']]['connected']+=1;
				                        $json = fopen(dirname(__FILE__,2).'/apps/'.$_POST['application'].'/keys.json', 'w');
			                            fwrite($json, json_encode($keys, JSON_PRETTY_PRINT));
			                            fclose($json);
			                            echo 'Connected';
				                    }
				                    else {
				                        echo 'Reached Maximum Devices';
				                    }
				                }
				                else {
				                    echo 'Inactive License';
				                }
				            }
				            else {
				                echo 'Unverified';
				            }
				        }
				        else {
				            echo 'Unvalid License';
				        }
			        }
			        else {
			            echo 'App Not Found';
			        }
                }
                else {
                    echo 'Bad Request';
                }
                break;
            case "tryDisconnect":
                if(isset($_POST['application'],$_POST['license'])) {
                    if(file_exists(dirname(__FILE__,2).'/apps/'.$_POST['application'].'/app.json')) {
				        $keys=json_decode(file_get_contents(dirname(__FILE__,2).'/apps/'.$_POST['application'].'/keys.json'),true);
				        if(isset($keys[$_POST['license']])) {
				            if(password_verify(md5(base64_decode($_POST['license'])),$keys[$_POST['license']]['hash'])) {
				                if($keys[$_POST['license']]['active'] == TRUE) {
				                    if($keys[$_POST['license']]['devices'] > 0) {
				                        $keys[$_POST['license']]['devices']-=1;
				                        $json = fopen(dirname(__FILE__,2).'/apps/'.$_POST['application'].'/keys.json', 'w');
			                            fwrite($json, json_encode($keys, JSON_PRETTY_PRINT));
			                            fclose($json);
			                            echo 'Disconnected';
				                    }
				                    else {
				                        echo 'Reached Minimum Devices';
				                    }
				                }
				                else {
				                    echo 'Inactive License';
				                }
				            }
				            else {
				                echo 'Unverified';
				            }
				        }
				        else {
				            echo 'Unvalid License';
				        }
			        }
			        else {
			            echo 'App Not Found';
			        }
                }
                else {
                    echo 'Bad Request';
                }
                break;
        }
    }

?>