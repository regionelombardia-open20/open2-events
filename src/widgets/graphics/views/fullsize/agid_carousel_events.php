<?php

/**
 * Aria S.p.A.
 * OPEN 2.0
 *
 *
 * @package    retecomuni\frontend\views\site\parts
 * @category   CategoryName
 */
use DateTime;
use DateTimeZone;
use IntlDateFormatter;
use open20\amos\events\AmosEvents;

?>



<div class="calendary">

    <section class="pb-5">

        <div>
            <!-- 2 variabili: ognuna per dire quale è la label attivo/disattivo -->

            <?php if( isset($list_events_grouped) ) : ?>
                
                <?php if( !empty($list_events_grouped) ) : ?>

                    <section class="calendar-section">
                        <div class=" pb-5 pt-0">
                            <div class="container">
                                <div class="row row-calendar">
                                    <div class="it-carousel-wrapper it-carousel-landscape-abstract-three-cols it-calendar-wrapper">
                                        <div class="it-header-block">
                                            <div class="it-header-block-title">
                                                <h4 class="mb-0 text-center text-white">
                                                    <?php 
                                                        // current date
                                                        $current_date = new DateTime('NOW');

                                                        echo ucfirst(strftime("%B", strtotime($current_date->format('F')))) . " " . $current_date->format('Y');
                                                    ?>
                                                </h4>
                                            </div>
                                        </div>
                                        <div class="it-carousel-all owl-carousel it-card-bg owl-loaded owl-drag">

                                            <div class="owl-stage-outer">
                                                <div class="owl-stage" style="transform: translate3d(0px, 0px, 0px); transition: all 0s ease 0s; width: 1702px;">
                                                    
                                                    <?php 
                                                        $count_events = 0;
                                                    ?>
                                                    <?php foreach ($list_events_grouped as $key => $events) : ?>
                                                        
                                                        <div class="owl-item active" style="width: 212.75px;">
                                                            <div class="it-single-slide-wrapper h-100 ">
                                                                <div class="card-wrapper h-100">
                                                                    <div class="card card-bg">
                                                                        <div class="card-body">
                                                                            <h5 class="card-title my-0 border-bottom ">
                                                                                <?php
                                                                                    // event date 
                                                                                    // $event_begin_date_hour = new DateTime($events[0]->begin_date_hour);
                                                                                    $event_begin_date_hour = new DateTime($key);
                                                                                    echo $event_begin_date_hour->format('d');
                                                                                ?>  
                                                                                <span>
                                                                                    <?= ucfirst(strftime("%A", strtotime($event_begin_date_hour->format('D')))) ?>
                                                                                </span>
                                                                            </h5>

                                                                            <?php foreach ($events as $key => $event) : ?>
                                                                                
                                                                                <div class="py-3 w-100 border-bottom  event-calendar-text Scadenze" style="display: inline-block;">
                                                                                    <a href="<?= $event->agid_website ?>" class=" text-decoration-none small w-100 h-100 d-inline-block "><?= $event->title ?></a>
                                                                                </div>
                                                                            
                                                                            <?php endforeach; ?>

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <?php 
                                                            $count_events++;
                                                        ?>

                                                    <?php endforeach; ?>

                                                    <?php if( $count_events != 4 ) : ?>
                                                        <?php 
                                                            $last_event_begin_date_hour = $event_begin_date_hour;
                                                        ?>
                                                        <?php for ( $i = 0; $i < (4 - $count_events); $i++ ) : ?>

                                                            <div class="owl-item active" style="width: 212.75px;">
                                                                <div class="it-single-slide-wrapper h-100 ">
                                                                    <div class="card-wrapper h-100">
                                                                        <div class="card card-bg">
                                                                            <div class="card-body">
                                                                                <h5 class="card-title my-0 border-bottom ">
                                                                                    <?php 
                                                                                        $last_event_begin_date_hour = $last_event_begin_date_hour->modify('+1 day');
                                                                                        echo $last_event_begin_date_hour->format('d');
                                                                                    ?>
                                                                                    <span>
                                                                                        <?= ucfirst(strftime("%A", strtotime($last_event_begin_date_hour->format('D')))) ?>
                                                                                    </span>
                                                                                </h5>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                                
                                                        <?php endfor; ?>
                                                    <?php endif; ?>
                                                    
                                                </div>
                                            </div>

                                            <div class="owl-nav disabled">
                                                <button class="owl-prev"></button>
                                                <button class="owl-next"></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                <?php else: ?>

                    <section class="calendar-section">
                        <div class=" pb-5 pt-0">
                            <div class="container">
                                <div class="row row-calendar">
                                    <div class="it-carousel-wrapper it-carousel-landscape-abstract-three-cols it-calendar-wrapper">
                                        <div class="it-header-block">
                                            <div class="it-header-block-title">
                                                <h4 class="mb-0 text-center text-white">
                                                    <?php 
                                                        // current date
                                                        $current_date = new DateTime('NOW');

                                                        echo ucfirst(strftime("%B", strtotime($current_date->format('F')))) . " " . $current_date->format('Y');
                                                    ?>
                                                </h4>
                                            </div>
                                        </div>
                                        <p style="margin-top:15px; text-align:center">Non ci sono eventi in programma</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                
                <?php endif; ?>

            <?php endif; ?>

        </div>
    </section>

</div>