<?php if(count($data) > 0): ?>        
  <table  class="table table-striped table-bordered dt-responsive datatable-buttons" style="border-collapse: collapse; border-spacing: 0; width: 100% !important;">
   
    <thead>
      <tr>
          <?php $__currentLoopData = $data[0]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

            <th><?php echo e($key); ?></th>

          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          <?php if(!empty($urls) && !(count($urls) == 1 && array_key_exists('add', $urls))): ?>
            <th class="noPrint">#Actions</th>
          <?php endif; ?>
      </tr>
    </thead>


    <tbody>
      <!-- For loop Rows-->
      <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>


      <!-- To get key-->
        <?php 
          foreach ($v as $key => $value) {
              $currKey = $value;
              break;                    
          }
        ?>
      <tr>

        <!-- For loop To print Rows-->
        <?php $__currentLoopData = $v; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kay => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <td>
            <?php if($kay == 'Logo'): ?>
              <?php if($val == "N/A"): ?>
              N/A
              <?php else: ?>
              <a  data-lightbox="<?php echo e(url('/storage'.$val)); ?>" href="<?php echo e(url('/storage'.$val)); ?>">
              <img style="width:100%;height: 90px" src="<?php echo e(url('/storage'.$val)); ?>">
            </a>
              <?php endif; ?>

            <?php elseif($kay == 'Image'): ?>
            <?php if($val == "N/A"): ?>
              N/A
              <?php else: ?>
              <a  data-lightbox="<?php echo e(url('/storage'.$val)); ?>" href="<?php echo e(url('/storage'.$val)); ?>">
              <img style="width:100%;height: 90px" src="<?php echo e(url('/storage'.$val)); ?>">
              </a>
            <?php endif; ?>

            <?php else: ?>
            <?php echo e($val); ?>

            <?php endif; ?>
          </td>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


  <!-- To check urls button without add-->
  <?php if(!empty($urls) && !(count($urls) == 1 && array_key_exists('add', $urls))): ?>
    <td>


      <!-- show button-->
       <?php if(isset($urls['create'])): ?>

                        <form method="POST" >
                            <?php echo csrf_field(); ?>    
                            <button formaction="<?php echo e($urls['create']); ?>/<?php echo e($currKey); ?>" class="btn btn-pink btn-sm" type="submit"><i class="fa fa-plus"></i> Create</button>
                          </form>

       <?php endif; ?>

      <!-- show button-->
       <?php if(isset($urls['preview'])): ?>

       <a href="<?php echo e($urls['preview']); ?>/<?php echo e($currKey); ?>" class="btn btn-pink btn-sm mr-2"><i class="fa fa-file"></i> Preview </a>

       <?php endif; ?>

      <!-- show button-->
       <?php if(isset($urls['show'])): ?>

       <a href="<?php echo e($urls['show']); ?>/<?php echo e($currKey); ?>" class="btn btn-primary btn-sm mr-2"><i class="fa fa-eye"></i> Show </a>

       <?php endif; ?>

       <!-- update button-->        
      <?php if(isset($urls['update'])): ?>
      <a href="<?php echo e($urls['update']); ?>/<?php echo e($currKey); ?>" class="btn btn-warning btn-sm mr-2"><i class="fa fa-pencil"></i> Update </a>
             
       <?php endif; ?>


       <!-- show button-->
       <?php if(isset($urls['showicon'])): ?>

       <a href="<?php echo e($urls['showicon']); ?>/<?php echo e($currKey); ?>" class="btn btn-primary btn-sm mr-2"><i class="fa fa-eye"></i></a>

       <?php endif; ?>

       <!-- update button-->        
      <?php if(isset($urls['updateicon'])): ?>
      <a href="<?php echo e($urls['updateicon']); ?>/<?php echo e($currKey); ?>" class="btn btn-warning btn-sm mr-2"><i class="fa fa-pencil"></i> </a>
             
       <?php endif; ?>

       <!-- delete button-->
        <?php if(isset($urls['deleteicon'])): ?>

        <a style="color:white;" data-toggle="modal" data-target=".bs-example-modal-lg_<?php echo e($currKey); ?>" class="btn btn-danger btn-sm"><i style="color:white;" class="fa fa-trash-o"></i>  </a>


        <div class="modal fade bs-example-modal-lg_<?php echo e($currKey); ?>" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content">

                        <div style="text-align: center;font-size: 25px;" class="modal-body">
                          <br>
                          <p>Are you Sure ?!</p><br><i style="color: #d9534f" class="fa fa-trash-o fa-5x"></i> 
                          <br><br><p>You Want to Delete This Row</p>
                        </div>
                        <br>
                        <div class="modal-footer">
                        <form method="POST" >
                            <?php echo csrf_field(); ?>    
                            <button formaction="<?php echo e($urls['deleteicon']); ?>/<?php echo e($currKey); ?>" class="btn btn-danger btn-sm" type="submit"><i class="fa fa-trash-o"></i> Delete</button>
                          </form>
                        </div>

                      </div>
                    </div>
                  </div>

        <?php endif; ?>





        <!-- delete button-->
        <?php if(isset($urls['delete'])): ?>

        <a style="color:white;" data-toggle="modal" data-target=".bs-example-modal-lg_<?php echo e($currKey); ?>" class="btn btn-danger btn-sm"><i style="color:white;" class="fa fa-trash-o"></i> Delete </a>


        <div class="modal fade bs-example-modal-lg_<?php echo e($currKey); ?>" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content">

                        <div style="text-align: center;font-size: 25px;" class="modal-body">
                          <br>
                          <p>Are you Sure ?!</p><br><i style="color: #d9534f" class="fa fa-trash-o fa-5x"></i> 
                          <br><br><p>You Want to Delete This Row</p>
                        </div>
                        <br>
                        <div class="modal-footer">
                        <form method="POST" >
                            <?php echo csrf_field(); ?>    
                            <button formaction="<?php echo e($urls['delete']); ?>/<?php echo e($currKey); ?>" class="btn btn-danger btn-sm" type="submit"><i class="fa fa-trash-o"></i> Delete</button>
                          </form>
                        </div>

                      </div>
                    </div>
                  </div>

        <?php endif; ?>

        <!-- Restore button-->
        <?php if(isset($urls['restore'])): ?>

        <a style="color:white;" data-toggle="modal" data-target=".bs-example-modal-lg_re_<?php echo e($currKey); ?>" class="btn btn-success btn-sm"><i style="color:white;" class="fa fa-history"></i> Restore </a>


        <div class="modal fade bs-example-modal-lg_re_<?php echo e($currKey); ?>" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content">

                        <div style="text-align: center;font-size: 25px;" class="modal-body">
                          <br>
                          <p>Are you Sure ?!</p><br><i style="color: #6fd088" class="fa fa-history fa-5x"></i> 
                          <br><br><p>You Want to Restore This Row</p>
                        </div>
                        <br>
                        <div class="modal-footer">
                        <form method="POST" >
                            <?php echo csrf_field(); ?>    
                            <button formaction="<?php echo e($urls['restore']); ?>/<?php echo e($currKey); ?>" class="btn btn-success btn-sm" type="submit"><i class="fa fa-history"></i> Restore</button>
                          </form>
                        </div>

                      </div>
                    </div>
                  </div>

        <?php endif; ?>

        <!-- user button-->
       <?php if(isset($urls['user'])): ?>

       <a href="<?php echo e($urls['user']); ?>/<?php echo e($currKey); ?>" class="btn btn-success btn-sm ml-2"><i class="mdi mdi-account-box-outline"></i></a>

       <?php endif; ?>


       <!-- show button-->
       <?php if(isset($urls['mail'])): ?>

                        <form method="POST" class="mr-2 ml-2" >
                            <?php echo csrf_field(); ?>    
                            <button formaction="<?php echo e($urls['mail']); ?>/<?php echo e($currKey); ?>" class="btn btn-pink btn-sm" type="submit"><i class="fa fa-mail"></i> Send</button>
                          </form>

       <?php endif; ?>

  </td>

  <?php endif; ?>
      </tr>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                              
      
    </tbody>
  </table>

<?php else: ?>
  <div>No Records Found</div>
<?php endif; ?>

<?php /**PATH C:\wamp64\www\smartvisionuae\Modules/Admin\resources/views/layouts/tables.blade.php ENDPATH**/ ?>