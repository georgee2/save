



<?php if($project->tour_url): ?>
<section class="mt-2 pb-6 px-6 pt-6 bg-white rounded-lg">
    <h4 class="fs-22 text-heading mb-6"><?php echo e(__('lang.virtual_tour')); ?></h4>
    <div class="embed-responsive embed-responsive-16by9 rounded-lg overflow-hidden">
        <iframe class="embed-responsive-item" 
                src="<?php echo e($project->tour_url); ?>" 
                allowfullscreen></iframe>
    </div>
</section>
<?php endif; ?>


<?php if($project->video_url): ?>
<section class="mt-2 pb-6 px-6 pt-6 bg-white rounded-lg">
    <h4 class="fs-22 text-heading mb-6"><?php echo e(__('lang.project_video')); ?></h4>
    <div class="embed-responsive embed-responsive-16by9 rounded-lg overflow-hidden">
        <?php
            // Convert YouTube URLs to embed format
            $videoUrl = $project->video_url;
            if (preg_match('/youtube\.com\/watch\?v=([^\&\?\/]+)/', $videoUrl, $matches)) {
                $videoUrl = 'https://www.youtube.com/embed/' . $matches[1];
            } elseif (preg_match('/youtu\.be\/([^\&\?\/]+)/', $videoUrl, $matches)) {
                $videoUrl = 'https://www.youtube.com/embed/' . $matches[1];
            } elseif (preg_match('/vimeo\.com\/([^\&\?\/]+)/', $videoUrl, $matches)) {
                $videoUrl = 'https://player.vimeo.com/video/' . $matches[1];
            }
        ?>
        <iframe class="embed-responsive-item" 
                src="<?php echo e($videoUrl); ?>" 
                allowfullscreen></iframe>
    </div>
</section>
<?php endif; ?>



<?php /**PATH C:\wamp64\www\smartvisionuae\resources\views/pages/projects/singleproject/location.blade.php ENDPATH**/ ?>