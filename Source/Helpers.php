<?php 

function site(string $param =null):string    
{
    
    if($param && !empty(SITE[$param])){
        return SITE[$param];
    }
    
    return SITE['root'];
    
}



function assets(string $path): string
{
    return SITE['root']."/views/assets/{$path}";
}

function url(string $uri): string
{
    return SITE['root']."/".$uri;
}

function flash(string $type=null, string $message=null): void
{
    if($type && $message){
        $_SESSION['flash'] = "<div class='alert alert-{$type} alert-dismissible fade show' role='alert'>{$message}
                                <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times</span>
                                </button>
                            </div>";
        return;
    }
    if(!empty($_SESSION['flash'])){
        echo $_SESSION['flash'];
        unset($_SESSION['flash']);
        return;
    }
}


function jsonResponse(int $status, array $mensagem):string
{
    http_response_code($status);
    return json_encode(
            [
                "status"=>$status, 
                "message"=> $mensagem
            ]
        );
    
    
}

function success(string $text):array
{
    return [
        "type"=>"success",
        "text"=>$text
    ];
    
}

function danger(string $text):array
{
    return [
        "type"=>"danger",
        "text"=>$text
    ];
    
}
function alert(string $text):array
{
    return [
        "type"=>"warning",
        "text"=>$text
    ];
    
}
function info(string $text):array
{
    return [
        "type"=>"info",
        "text"=>$text
    ];
    
}
