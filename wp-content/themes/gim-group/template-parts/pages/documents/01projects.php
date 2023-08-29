<?php
    // if(!empty($_GET['type']) && $_GET['type'] == 'real'){
    //     $post_type = 'real';
    // } else if(!empty($_GET['type']) && $_GET['type'] == 'parking'){
    //     $post_type = 'parking';
    // } else{
    //     $post_type = 'apart';
    // }
    $selected_project_id = isset($_GET['project_id']) ? $_GET['project_id'] : '';
?>
 

<section class="_section mt-14">
    <div class="_wrapper">
        <h2 class="_h">Документы</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-5 gap-y-7 mt-7">
            <?php
                $projects = get_terms(array(
                    'taxonomy' => 'project', 
                    'hide_empty' => false,    
                ));
            ?>
            <select id="select-document" class="col-span-1 md:col-span-1 py-3.5 px-3 rounded-lg">
                <option value="0">
                    Выберете проект
                </option>
                <?php
                    if ($projects && !is_wp_error($projects)) {
                        foreach ($projects as $project) {
                            $project_image = get_field('image_project', 'project_' . $project->term_id);
                            ?>
                                <option value="<?php echo $project->term_id; ?>" <?php echo $selected_project_id  == $project->term_id ? ' selected' : ''; ?>>
                                    <?php echo $project->name; ?>
                                </option>
                            <?php
                        }
                    }
                ?>
            </select>
                
                    <?php
                        foreach ($projects as $project) {
                            $block_style = $selected_project_id == $project->term_id ? 'block' : 'none';
                    ?>
                            <div class="col-span-1 md:col-span-2" data-project="<?php echo $project->term_id;?>" style="display: <?php echo $block_style; ?>">
                            <?php
                                $documents = get_posts(array(
                                    'post_type' => 'document',
                                    'numberposts' => -1,
                                    'tax_query' => array(
                                        array(
                                            'taxonomy' => 'project',
                                            'field' => 'term_id',
                                            'terms' => $project->term_id,
                                        ),
                                    ),
                                ));
                                
                                if ($documents) {
                                    echo '<ul>';
                                    foreach ($documents as $document) {
                                        $link = get_field('file_document', $document->ID); 
                                        $title = get_field('title_document', $document->ID); 
                                        echo '<li><a class="underline text-_blue_for-text" href="' . $link .'">' . $title . '</a></li>';
                                    }
                                    echo '</ul>';
                                } else {
                                    echo 'Нет документов для этого проекта.';
                                }

                            ?>
                                </div>
                            <?php
                        }
                    ?>
                
        </div>
    </div>
</section>
<script>
    const selectDocument = document.getElementById('select-document');
    const projectDivs = document.querySelectorAll('[data-project]');

    selectDocument.addEventListener('change', function() {
        const selectedProjectId = this.value;

        projectDivs.forEach(function(div) {
            if (div.dataset.project === selectedProjectId) {
                div.style.display = 'block';
            } else {
                div.style.display = 'none';
            }
        });
    });
</script>