<div class="container">
<?php $session=$this->session->userdata['logged_in'];?>
    <h2>Gestion des utilisateurs</h2>
    <br>
    <a href="javascript:void(0)" class="btn btn-success ml-3" id="ajouter-user"> <i class="fa fa-plus"></i> Ajouter</a>
    <br><br>

    <table class="table table-bordered table-striped" id="users_liste"> 
        <thead style="background-color:rgba(200,0,0,0.5)">
            <tr>
                <th style="text-align:center">ID</th>
                <th style="text-align:center">Nom d'utilisateur</th>
                <th style="text-align:center">Nom et Prénom</th>
                <th style="text-align:center">Adresse email</th>
                <th style="text-align:center">Fonction</th>
                <th style="text-align:center">Actions</th>
            </tr>
        </thead>
       
        <tbody>
            <?php if($users): ?>
                <?php foreach($users as $user): ?>
                    <tr id="user_id_<?=$user->id;?>">
                        <td style="text-align:center"><?= $user->id ?></td>
                        <td style="text-align:center"><?= $user->login ?></td>
                        <td style="text-align:center"><?= $user->fullname ?></td>
                        <td style="text-align:center"><?= $user->adress_email ?></td>
                        <td style="text-align:center"><?= $user->name ?></td>
                        <td style="text-align:center">
                            <a href="javascript:void(0)" id="<?php if($user->adress_email == $session['adresse_email']){ echo "edit-users";} ?>" data-id="<?=$user->id?>" class="btn btn-info" <?php if($user->adress_email != $session['adresse_email']){ echo "disabled";} ?>><i class="fa fa-edit"></i> Modifier</a>
                            <a href="javascript:void(0)" id="delete-users" data-id="<?=$user->id?>" class="btn btn-danger delete-user"> <i class="fa fa-trash"></i> Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach;?>
            <?php endif;?>        
        </tbody>
    </table>
</div>


<!--Modal for add & edit users-->
<div class="modal fade" id="ajax-user-modal" aria-hidden="true">²
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <a class="close" data-dismiss="modal">×</a>
                <h4 class="modal-title" id="userCrudModal"></h4>
            </div>
            <form id="userForm" name="userForm" class="form-horizontal">
                <div class="modal-body" style="width:95%;margin:auto">
                    
                    <div class="alert alert-danger" hidden >

                    </div>
                
                    <input type="hidden" name="user_id" id="user_id">

                    <div class="form-group">
                        <label for="name" class="control-label">Nom d'utilisateur : </label>
                        <input type="text" class="form-control" id="username" name="username" placeholder="Entrer le nom d'utilisateur" value="" required="">
                    </div>

                    <div class="form-group">
                        <label for="name" class="control-label">Nom et Prénom : </label>
                        <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Entrer votre nom et prénom" value="" required="">
                    </div>

                    <div class="form-group">
                        <label for="name" class="control-label">Adresse email : </label>
                        <input type="email" class="form-control" id="adresse_email" name="adresse_email" placeholder="Entrer votre adresse e-mail" value="" required="">
                    </div>

                    <div class="form-group">
                        <label for="name" class="control-label">Fonction : </label>
                        <select name="fonction" id="fonction" class="form-control">
                            <option value=""></option>
                            <?php foreach ($profils as $profil) : ?>
                                <option value="<?= $profil->id_user_profil ?>"><?= $profil->name ?></option>
                            <?php endforeach ;?>    
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="name" class="control-label">Mot de passe : </label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Entrer votre mot de passe" value="" required="">
                    </div>

                    <div class="form-group">
                        <label for="name" class="control-label">Confirmation du mot de passe : </label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirmer votre mot de passe" value="" required="">
                    </div>
                
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="btn-save" value="create">Enregister</button>
                    <button class="btn btn-default" data-dismiss="modal">Fermer</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
   var SITEURL='<?php echo base_url();?>';
   

   $(document).ready(function(){
        $('#users_liste').DataTable();
        
       /**Quand l'utilisateur clic sur me boutton "Ajouter" */
       $('#ajouter-user').click(function(){
            $('#btn-save').val('create-user');
            $('#user_id').val('');
            $('#userForm').trigger("reset");
            $('#userCrudModal').html("Ajout utilisateur");
            $('#ajax-user-modal').modal('show');
       });

       /**Quand l'utilisateur clic sur me boutton "Modifier" */
       $('body').on('click','#edit-users',function(){
           var user_id=$(this).data("id");
          
           $.ajax({
               type:"Post",
               url:SITEURL + "gestion_utilisateur/get_user_by_id",
               data:{
                   user_id: user_id
               },
               dataType: "json",
               success: function (res){
                    if(res.success == true){
                        $('#adresse_email-error').hide();
                        $('#password-error').hide();
                        $('#password1-error').hide();
                        $('#userCrudModal').html('Modifier votre profil');
                        $('#btn-save').val('Modifier');
                        $('#ajax-user-modal').modal('show');
                        $('#user_id').val(res.data.id);
                        $('#username').val(res.data.login);
                        $('#fullname').val(res.data.fullname)
                        $('#adresse_email').val(res.data.adress_email);
                        $('#fonction').val(res.data.profil_id);
                        $('#password').val(res.data.password);
                        $('#confirm_password').val(res.data.password);
                    }
               },
               error:function(data){
                   console.log('error',data);
               }
           });
       });

       $('body').on('click','#delete-users',function(){
           var user_id=$(this).data("id");
           
           if(confirm("Etes-vous sûre de vouloir supprimer?")){
               $.ajax({
                   type:"Post",
                   url:SITEURL + "gestion_utilisateur/delete",
                   data:{
                    user_id:user_id
                   },
                   dataType:'json',
                   success:function(data){
                        $('#user_id_' + user_id).remove();
                        setTimeout(function(){
                            location.reload();
                        },100);
                   }, 
                   error:function(data){
                       console.log('error:',data);
                   }
               });
           }
       });
   }); 

  
   if($('#userForm').length >0){
       $('#userForm').validate({
            rules:{
                password:{
                    required:true,
                },
                confirm_password:{
                    required:true,
                    equalTo:"#password"
                }
            },
           submitHandler: function(form){
               var actionType= $('#btn-save').val();
               $('#btn-save').html('Envoie...');
               var serialize=$('#userForm').serialize();
               $.ajax({
                   url:SITEURL + "gestion_utilisateur/store",
                   type:"Post",
                   dataType:'json',
                   data: serialize,
                   
                   success: function(res){
                    var user='<tr id="user_id_'+ res.data.id + '"><td>' + res.data.id + '</td><td>' + res.data.login + '</td><td>' + res.data.fullname + '</td><td>'+ '</td><td>' + res.data.profil_id + '</td><td>' + res.data.adress_email + '</td><td>';
                    user+= '<td><a href="javascript:void(0)" id="edit-user" data-id="' + res.data.id + '"class="btn btn-info">Modifier</a><a href="javascript:void(0)" id="delete-user" data-id="' + res.data.id + '"class="btn btn-danger delete-user">Supprimer</a></td></tr>';

                    if(actionType =="create-user"){
                        
                       $('#users_liste').prepend(user);
                    }else{
                       $('#user_id_' + res.data.id_users).replaceWith(user);
                    }

                    $('#userForm').trigger("reset");
                    $('#ajax-user-modal').modal('hide');
                    $('#btn-save').html('Enregister modification');
                    setTimeout(function(){
                        location.reload();
                    },100);
                   },

                  error:function(data){
                    console.log('error:',data);
                    $('#btn-save').html("Le Nom d'utilisateur/Nom et Prénom/adresse email existe déjà!!");
                    $('#btn-save').css({
                        color:'white',
                        backgroundColor:'red'
                    });    
                  }
               });
           }
       })
   }
</script>