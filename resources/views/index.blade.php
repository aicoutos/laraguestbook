<!DOCTYPE html>
<html lang="pt-br" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>{{$_ENV['APP_NAME']}}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <?php
    //https://laravel.com/docs/6.x/helpers#paths
    $cssFile='/css/master.css';
    $filename=public_path().$cssFile;
    $cssUrl=asset($cssFile).'?'.md5_file($filename);
    ?><link rel="stylesheet" href="<?php print $cssUrl; ?>">
    <script type="text/javascript" src="{{asset('/js/jquery.min.js')}}"></script>
    <?php
    $jsFile='/js/main.js';
    $filename=public_path().$jsFile;
    $jsUrl=asset($jsFile).'?'.md5_file($filename);
    ?><script type="text/javascript" src="<?php print $jsUrl; ?>"></script>
</head>
<body>
    <div class="c">
        <div class="r">
            <div class="g3">
            </div><!-- g3 -->
            <div class="g6">
                <div class="center">
                    <h1>{{$_ENV['APP_NAME']}}</h1>
                    <?php
                    if(Session::has('success')){
                        print '<p>';
                        print Session::get('success');
                        print '</p>';
                    }
                    $countErrors=count($errors);
                    if($countErrors>0){
                        if($countErrors==1){
                            print '<p><b>Erro:</b> ';
                            print $errors->all()[0];
                            print '</p>';
                        }else{
                            print '<p><b>Erros:</b></p>';
                            print '<ul>';
                            foreach ($errors->all() as $erro) {
                                print '<li>'.$erro.'</li>';
                            }
                            print '</ul>';
                        }
                    }
                    ?>
                    <form class="" action="{{url('/mensagens')}}" method="post">
                        <textarea name="mensagem" rows="4" maxlength="280"></textarea>
                        {{ csrf_field() }}
                        <input type="hidden" value="{{getenv('cookieDelete')}}" name="cookieDelete">
                        <button type="submit" name="button">
                            Enviar
                        </button>
                    </form>
                </div><!-- center -->
                <?php
                if(isset($mensagens) && count($mensagens)>0){
                    foreach ($mensagens as $mensagem) {
                        print '<div id="msg'.$mensagem->id.'">';
                        print '<p><small>';
                        print $mensagem->created_at;
                        print '</small>';
                        $onclk='javascript:deleteMsg('.$mensagem->id.');';
                        if(getenv('cookieDelete')==$mensagem->cookieDelete){
                            print '<a class="right" href="javascript:void(0);';
                            print '" onclick="'.$onclk.'">';
                            print 'X</a>';
                        }
                        print '</p>';
                        print '<p>'.$mensagem->mensagem.'</p><hr>';
                        print '</div>';
                    }
                }else{
                    print 'Nenhuma mensagem encontrada';
                }
                ?>
            </div><!-- g6 -->
        </div><!-- r -->
    </div><!-- c -->
