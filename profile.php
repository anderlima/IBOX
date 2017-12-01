<?php 
require_once("db_ci.php");
require_once("headprofile.php");
require_once("user_logic.php");
checkUser();

$team_id = $_POST['teamid'] ? $_POST['teamid'] : $_SESSION['team'];
$_SESSION['team'] = $team_id;
$myteams = getMyTeams($db, Whois());
$profiles = getProfiles($db, $team_id);
$team = getInfoReg($db, $team_id, "teams");
$i = 0;

if($myteams == null){
    $_SESSION["danger"] = "You have no team. Please create a team or ask your team moderator to add you as a member!";
}
?>
    	<div class="col-md-10">
          <div class="content-box-large">
            <div class="container">
              </div>
                 <div class="row">
                    <?php showAlert("success"); ?>
                    <?php showAlert("danger"); ?>
                 <div class="panel-heading col-md-10">
                     <div class="panel-title"><h3 style="color: #428dca;"><?=$team['name']?></h3><br></div>
                 </div>
                </div>
              <div class="panel-body">
                 <div class="row">
                 <form action="add_member.php" method="post">
                    <input type="hidden" name="teamid" value="<?=$team_id?>">
                    <div class="col-md-2"><h4>Add Member</h4></div>
                    <div class="col-md-6">
                        <input id="faces-input" name="email" class="form-control typeahead" autocomplete="off" />
                    </div>
                     <div class="col-md-2">
                        <select name="level" class="form-control">
                        <option value="user">user</option>
                        <option value="moderator">moderator</option>
                        <option value="admin">admin</option>
                        </select>
                    </div>
                     <div class="col-md-2">
                       <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </form>         
                </div><br><br><br>
                
                <div class="row">
                <?php
                foreach($profiles as $profile):
                ?>
                <div class="col-xs-2" style="box-shadow: 4px 4px 2px grey; padding: 12px; margin: 5px;">
                        <img style="float:left;" src="http://images.tap.ibm.com:10002/image/<?=$profile['email']?>.jpg?s=31">
                    <div style="float: right;">
                        <?=$profile['email']?><br>
                        <b><?=$profile['level']?></b>
                        <div style="float: right;">
                        <form class="col-xs-1" action="edit_profile.php" method="post">
                        <input type="hidden" name="teamid" value="<?=$profile['id']?>">
                        <button type="button" title="Alter Profile" data-toggle="modal" data-target="#myModal<?=$i?>" style="color: #5CB85C; border: none; background: white;"><i class="glyphicon glyphicon-cog"></i></button>
                        </form>
                        </div> 
                    </div>
                </div>
                <?php
                $i++;
                endforeach;
                $i=0;
                foreach($profiles as $profile):             
                ?>
       
          <div class="modal fade" id="myModal<?=$i?>" role="dialog">
            <div class="modal-dialog"> 
                
               <div class="modal-content">
                   <div class="modal-header">
                       <button type="button" class="close" data-dismiss="modal">&times;</button>
                       <h4 class="modal-title"><?=$profile['email']?></h4>
                   </div>
                   <div class="modal-body">
                    <form action="alter_member.php" method="post">
                     <input type="hidden" name="profileid" value="<?=$profile['id']?>">
                     <div class="col-md-5">
                        <select name="level" class="form-control">
                        <option vlaue="user">user</option>
                        <option value="moderator">moderator</option>
                        <option vlaue="user">admin</option>
                        </select>
                    </div>
                    </div>
                       <div class="modal-footer">
                       <button type="submit" name="alter" value="alter" class="btn btn-success">Alter</button>
                       <button type="submit" name="remove" class="btn btn-danger">Remove</button>
                       </div>
                    </form> 
               </div> 
             </div>
            </div>  
          </div>
               <?php
                $i++;
                endforeach;  
               ?>
              </div>
          </div>
        </div>
            
<script>
          $(function(){
            ta1 = FacesTypeAhead.init(
                $('#faces-input')[0],
                {
                    key: "IBOX;alimao@br.ibm.com",
                    faces: {
                        largeImageSize: 50,
                        smallImageSize: 32,
                        headerLabel: "People",
                        onclick: function(person) {
                            return person.email;
                        }
                    },
                    topsearch: {
                        headerLabel: "w3 Results",
                        enabled: true,
 
        //Topsearch server (don't change this)
        host: 'http://topsearch.ciolab.ibm.com',
 
        //Total number of topsearch results to show
        maxResults: 4,
 
        moreResultsUrl: "http://w3.ibm.com/search/do/search?qt=${query}",
 
        moreResultsLabel: "See more w3 results",
 
        headerLabel: "Top w3 Results",
 
        iconUrl: "http://w3.ibm.com/jct03001pt/w3ODWThemeSkin/themes/html/w3ODWTheme/images/favicon.ico",
 
        //Click handler selecting a link
        onclick: function(link) {
            location.href=link.url;
        }
                    }
                });

    });
</script>            

    </div></div>
    </br></br></br></br>
    <div class="navbar navbar-fixed-bottom">
      <footer class="footer">
        <div class="container">
            <div class="copy text-center">
               IBOX  2017 <a href='#'>Wiki Link</a>
            </div>
        </div>
      </footer>
    </div>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="js/custom.js"></script>
  </body>
</html>