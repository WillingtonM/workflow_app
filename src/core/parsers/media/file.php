<div class="col-12">
    <a type="button" class="btn btn-dark border-radius-lg" onclick="requestModal(post_modal[12], 'fileModal', {})" <?= ((!$is_admin || !$subscription) ? 'disabled' : '') ?>> Upload File </a>

    <div class="row">

        <?php 
        if (is_array($gall_qry) || is_object($gall_qry)) :  
            foreach ($gall_qry as $value) : 
                $myDateTime   = DateTime::createFromFormat('Y-m-d H:i:s', $value['media_publish_date']); 
                $file_parts = pathinfo($value['media_image']);
                $fl_ext     = 'fa-file';
                $text_colr  = 'text-secondary';
                if (array_key_exists('extension', $file_parts)) {
                    switch ($file_parts['extension']) {
                        case "pdf":
                            $fl_ext = 'fa-file-pdf';
                            $text_colr = 'text-danger';
                            break;

                        case "doc" || 'docx':
                            $fl_ext = 'fa-file-word';
                            $text_colr = 'text-primary';
                            break;

                        case "": // Handle file extension for files ending in '.'
                            $fl_ext = 'fa-file';
                        case NULL: // Handle no file extension
                            $fl_ext = 'fa-file';
                            break;
                    }
                }

                require $config['PARSERS_PATH'] . 'media' . DS . 'file_div.php';

            endforeach;  
        endif; 
        ?>

    </div>

</div>