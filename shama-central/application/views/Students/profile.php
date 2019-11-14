<!-- Upper row--> 
      <div class="row">
        <div class="col-sm text-left">
          <span>
            <?php 
           
              if($profile_image){
                ?>
               <img src="<?php echo IMAGE_LINK_PATH."upload/profile/".$profile_image; ?>" alt="Avatar" width="50" class="rounded-circle">
              <?php 
             
              }
               else{
              
                ?>
                 <img src="https://www.w3schools.com/howto/img_avatar2.png" alt="Avatar" width="50" class="rounded-circle">
                <?php
              }
            ?>
           
            <h4 class="user-name d-inline"><?php echo $name; ?></h4>
          </span>
        </div>
        <div class="col-sm text-right class-info">
          <ul class="list-inline class-info-list">
            <li class="list-inline-item">
              <p>Timetable mode is enabled</p>
              <p>Class: KG(Section)</p>
              <p>Subject: English</p>
            </li>
          </ul>
        </div>
      </div>
