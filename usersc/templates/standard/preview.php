<?php
$template_override = "standard";
require_once '../../../users/init.php';
require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
if(!hasPerm([2],$user->data()->id)){
  die("no permission to be here");
}
?>

    <div class="text-center">
        <h2><a href="../../../users/admin.php?view=templates"><span class="fa fa-arrow-left"></span> Back to Themes</a></h2>
    </div>
    <section class="py-4 mt-2">
        <div class="row">
            <div class="col-md-12">
                <h2>Tabs</h2>
                <ul id="tabsJustified" class="nav nav-tabs">
                    <li class="nav-item"><a href="" data-target="#home1" data-toggle="tab" class="nav-link small text-uppercase">Home</a></li>
                    <li class="nav-item"><a href="" data-target="#profile1" data-toggle="tab" class="nav-link small text-uppercase active">Profile</a></li>
                    <li class="nav-item"><a href="" data-target="#messages1" data-toggle="tab" class="nav-link small text-uppercase">Messages</a></li>
                </ul>
                <br>
                <div id="tabsJustifiedContent" class="tab-content">
                    <div id="home1" class="tab-pane fade">
                        <div class="list-group"><a href="" class="list-group-item d-inline-block"><span class="float-right badge badge-pill badge-dark">51</span> Home Link</a> <a href="" class="list-group-item d-inline-block"><span class="float-right badge badge-pill badge-dark">8</span> Link 2</a>                            <a href="" class="list-group-item d-inline-block"><span class="float-right badge badge-pill badge-dark">23</span> Link 3</a> <a href="" class="list-group-item d-inline-block text-muted">Link n..</a></div>
                    </div>
                    <div id="profile1" class="tab-pane fade active show">
                        <div class="row pb-2">
                            <div class="col-md-7">
                                <p>Tabs can be used to contain a variety of content &amp; elements. They are a good way to group <a href="" class="link">relevant content</a>. Display initial content in context to the user. Enable the user to flow through
                                    <a href="" class="link">more</a> information as needed.
                                </p>
                            </div>
                            <div class="col-md-5"><img src="//dummyimage.com/800x300.png/5fa2dd/ffffff" class="float-right img-fluid img-rounded"></div>
                        </div>
                    </div>
                    <div id="messages1" class="tab-pane fade">
                        <div class="list-group"><a href="" class="list-group-item d-inline-block"><span class="float-right badge badge-pill badge-dark">44</span> Message 1</a> <a href="" class="list-group-item d-inline-block"><span class="float-right badge badge-pill badge-dark">8</span> Message 2</a>                            <a href="" class="list-group-item d-inline-block"><span class="float-right badge badge-pill badge-dark">23</span> Message 3</a> <a href="" class="list-group-item d-inline-block text-muted">Message n..</a></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-4 mt-2">
        <div class="row">
            <div class="col-md-12">
                <h2>Progress Bars</h2>
                <div id="card_stats">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-6 my-2">
                                <div class="card card-body p-3"><span class="text-primary"><span class="badge badge-primary float-right">+ 13%</span> Sign-ups </span>
                                    <div class="progress mt-4">
                                        <div class="progress-bar w-25 bg-primary"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 my-2">
                                <div class="card card-body p-3"><span class="text-primary"><span class="badge badge-primary float-right">80%</span> Usage </span>
                                    <div class="progress mt-4">
                                        <div class="progress-bar w-75"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 my-2">
                                <div class="card card-body p-3"><span class="text-primary"><span class="badge badge-primary float-right">78</span> Bursts </span>
                                    <div class="progress mt-4">
                                        <div class="progress-bar bg-primary w-75"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 my-2">
                                <div class="card card-body p-3"><span class="text-success"><span class="badge badge-success float-right">+ 26%</span> Returning </span>
                                    <div class="progress mt-4">
                                        <div class="progress-bar bg-success w-25"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 my-2">
                                <div class="card card-body p-3"><span class="text-primary"><span class="badge badge-primary float-right">201</span> Sales </span>
                                    <div class="progress mt-4">
                                        <div class="progress-bar w-50 bg-primary"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 my-2">
                                <div class="card card-body p-3"><span class="text-success"><span class="badge badge-success float-right">+ 74%</span> Pageviews </span>
                                    <div class="progress mt-4">
                                        <div class="progress-bar bg-success w-75"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="py-4 mt-2">
        <div class="row">
            <div class="col-md-12">
                <h2>Lists</h2>
                <div id="card_contacts" class="card border-0">
                    <div id="contacts" aria-expanded="true" role="tabpanel" class="panel-collapse collapse show">
                        <ul id="contact-list" class="list-group">
                            <li class="list-group-item d-block">
                                <div class="row">
                                    <div class="col-12 col-sm-6 col-md-2"><img src="//placehold.it/80" alt="Mike Anamendolla" class="img-fluid rounded-circle mx-auto d-block"></div>
                                    <div class="col-12 col-sm-6 col-md-10 text-center text-sm-left">
                                        <label class="name">Mike Anamenda</label>
                                        <br> <span class="text-muted">5842 Hillcrest Rd</span>
                                        <br> <span class="text-muted small">(870) 288-4149</span>
                                        <br> <a href="" class="link small text-truncate">mike.ana@example.com</a></div>
                                </div>
                            </li>
                            <li class="list-group-item d-block">
                                <div class="row">
                                    <div class="col-12 col-sm-6 col-md-2"><img src="//placehold.it/80" alt="Seth Frazier" class="img-fluid rounded-circle mx-auto d-block"></div>
                                    <div class="col-12 col-sm-6 col-md-10 text-center text-sm-left">
                                        <label class="name">Seth Frazier</label>
                                        <br> <span class="text-muted">7396 E North St</span>
                                        <br> <span class="text-muted small">(560) 180-4143</span>
                                        <br> <a href="" class="link small text-truncate">seth.frazier@example.com</a></div>
                                </div>
                            </li>
                            <li class="list-group-item d-block">
                                <div class="row">
                                    <div class="col-12 col-sm-6 col-md-2"><img src="//placehold.it/80" alt="Rosemary Porter" class="img-fluid rounded-circle mx-auto d-block"></div>
                                    <div class="col-12 col-sm-6 col-md-10 text-center text-sm-left"><span title="left you a message" class="fa fa-envelope fa-lg text-danger float-right"></span>
                                        <label class="name">Rosemary Porter</label>
                                        <br> <span class="text-muted">5267 Cackson St</span>
                                        <br> <span class="text-muted small">(497) 160-9776</span>
                                        <br> <a href="" class="link small text-truncate">rosemary.porter@example.com</a></div>
                                </div>
                            </li>
                            <li class="list-group-item d-block">
                                <div class="row">
                                    <div class="col-12 col-sm-6 col-md-2"><img src="//placehold.it/80" alt="Debbie Schmidt" class="img-fluid rounded-circle mx-auto d-block"></div>
                                    <div class="col-12 col-sm-6 col-md-10 text-center text-sm-left">
                                        <label class="name">Debbie Schmidt</label>
                                        <br> <span class="text-muted">3903 W Alexander Rd</span>
                                        <br> <span class="text-muted small">(867) 322-1852</span>
                                        <br> <a href="" class="link small text-truncate">debbie.schmidt@example.com</a></div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="row my-3">
                    <div class="col-sm-6">
                        <div id="card_list" class="card border-0">
                            <div class="list-group">
                                <a href="#" class="list-group-item">
                                    <p class="list-group-item-text m-0">Grapes</p>
                                </a>
                                <a href="#" class="list-group-item justify-content-between">
                                    <p class="list-group-item-text m-0">Milk</p> <span><i class="ion-ios-star-outline"></i></span></a>
                                <a href="#" class="list-group-item">
                                    <p class="list-group-item-text m-0">Apple Chips</p>
                                </a>
                                <a href="#" class="list-group-item">
                                    <p class="list-group-item-text m-0">Fried Dough</p>
                                </a>
                                <a href="#" class="list-group-item">
                                    <p class="list-group-item-text m-0">Berries</p>
                                </a>
                                <a href="#" class="list-group-item">
                                    <p class="list-group-item-text m-0">Salad</p>
                                </a>
                                <a href="#" class="list-group-item">
                                    <p class="list-group-item-text m-0">Cookies &amp; Crackers</p>
                                </a>
                                <a href="#" class="list-group-item">
                                    <p class="list-group-item-text m-0 font-weight-bold">See More...</p>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div id="accordion" class="accordion">
                            <div class="card card-default panel"><a href="" data-toggle="collapse" data-target="#collapseOne" class="card-header text-white bg-dark"><span class="card-title">
                                        Accordion Item 1
                                    </span></a>
                                <div id="collapseOne" class="card-body collapse show" data-parent="#accordion" >
                                    <p>Food truck quinoa nesciunt laborum for labo lucn. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth
                                        nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                                    </p>
                                </div> <a href="" data-toggle="collapse" data-target="#collapseTwo" class="card-header text-white bg-dark collapsed"><span class="card-title">
                                        Accordion Item 2
                                    </span></a>
                                <div id="collapseTwo" class="card-body collapse" data-parent="#accordion">
                                    <p>Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. Officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor,
                                        sunt cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable
                                        VHS.
                                    </p>
                                </div> <a href="" data-toggle="collapse" data-target="#collapseThree" class="card-header text-white bg-dark collapsed"><span class="card-title">
                                        Accordion Item 3
                                    </span></a>
                                <div id="collapseThree" class="card-body collapse" data-parent="#accordion">
                                    <p>Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf
                                        moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. samus labore sustainable VHS.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> <span id="jumbotron" class="anchor"></span>
    <section class="d-flex align-items-center justify-content-center">
        <div class="row w-100">
            <div class="col mb-4">
                <div id="header" class="jumbotron mb-0 d-flex align-items-center flex-column justify-content-center p-5">
                    <h1 class="display-4">Jumbotron</h1>
                    <p>Some perfectly centered content goes here</p>
                    <p class="lead"><a href="#" role="button" class="btn btn-secondary btn-lg">Learn more</a></p>
                </div>
            </div>
        </div>
    </section>
    <section class="py-4 mt-2">
        <div class="row">
            <div class="col-md-12">
                <h2>Cards</h2>
                <div id="card_counts" class="p-0">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="card text-white bg-dark text-center pt-2">
                                <div class="card-body card-title">

                                    <h6 class="text-light">56 Likes</h6></div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="card text-white bg-primary text-center pt-2">
                                <div class="card-body card-title">

                                    <h6 class="text-light">209 Followers</h6></div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="card text-white bg-success text-center pt-2">
                                <div class="card-body card-title">

                                    <h6 class="text-light">20 Snaps</h6></div>
                            </div>
                        </div>
                        <div class="w-100 py-3"></div>
                        <div class="col-sm-4">
                            <div class="card text-white bg-danger text-center pt-2">
                                <div class="card-body card-title">

                                    <h6 class="text-light">1,110 Views</h6></div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="card text-white bg-info text-center pt-2">
                                <div class="card-body card-title">

                                    <h6 class="text-light">90 Views</h6></div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="card text-white bg-warning text-center pt-2">
                                <div class="card-body card-title">

                                    <h6 class="text-light">44 Apps</h6></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row py-3">
                    <div class="col-lg-4 col-sm-6 py-3">
                        <div class="card card-default h-100">
                            <div class="card-img-top"><img src="//placehold.it/600x300" alt="card image 1" class="grayscale img-fluid mx-auto d-block"></div>
                            <div class="card-body d-flex flex-column">
                                <p class="text-justify">Ovi lipsim diro? Wi, wi, garius azdipiscing elit. Duis pha codeply.</p> <a href="" data-target="#profileModal" data-toggle="modal" data-caption="Tammy" data-image="//placehold.it/600x300" class="btn btn-secondary btn-lg btn-block text-truncate mt-auto">View Profile</a></div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6 py-3">
                        <div class="card card-default h-100">
                            <div class="card-img-top"><img src="//placehold.it/600x300" alt="card image 3" class="grayscale img-fluid mx-auto d-block"></div>
                            <div class="card-body d-flex flex-column">
                                <p class="text-justify">Shiny, shiny, shiny.</p> <a href="" data-target="#profileModal" data-toggle="modal" data-caption="Marcus" data-image="//placehold.it/600x300" class="btn btn-secondary btn-lg btn-block text-truncate mt-auto">View Profile</a></div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6 mx-auto py-3">
                        <div class="card card-default h-100">
                            <div class="card-img-top"><img src="//placehold.it/600x300" alt="card image 3" class="grayscale img-fluid mx-auto d-block"></div>
                            <div class="card-body d-flex flex-column">
                                <p class="text-justify">Varius azdipiscing elit. Duis pharetra, ovi lipsim diro?</p> <a href="" data-target="#profileModal" data-toggle="modal" data-caption="Carry" data-image="//placehold.it/600x300" class="btn btn-secondary btn-lg btn-block text-truncate mt-auto">View Profile</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <span id="alerts" class="anchor"></span>
    <section class="py-4 mt-2">
        <div class="row">
            <div class="col-md-12">
                <h2>Alerts &amp; Notifications</h2>
                <div class="row">
                    <div class="col-md-12">
                        <div role="alert" class="alert alert-success">
                            <h4 class="alert-heading">Yes!</h4> Aww yeah, you successfully read this important alert message. This example text is going to run a bit longer so that you can see how spacing within an alert works with this kind of content. Imagine the content here.
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div role="alert" class="mt-1 alert alert-info alert-dismissible fade show">
                            <button type="button" data-dismiss="alert" aria-label="Close" class="close"><span aria-hidden="true">�</span></button> <span class="font-weight-bold">Heads up!</span> Vestibulum tincidunt ullamcorper eros eget luctus. Nulla <a href="#" class="alert-link">info</a> porttitor libero.
                        </div>
                        <div role="alert" class="mt-1 alert alert-danger alert-dismissible fade show">
                            <button type="button" data-dismiss="alert" aria-label="Close" class="close"><span aria-hidden="true">�</span></button> <span class="font-weight-bold">Yo there!</span> You should check <a href="#" class="alert-link">danger</a> in on some of those fields below.
                        </div>
                        <div role="alert" class="mt-1 alert alert-warning alert-dismissible fade show">
                            <button type="button" data-dismiss="alert" aria-label="Close" class="close"><span aria-hidden="true">�</span></button>
                            Food truck fixie locavore Exercitation, blog <a href="#" class="alert-link">warning</a> sartorial PBR leggings.
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div role="alert" class="mt-1 alert alert-primary bg-primary text-white alert-dismissible fade show">
                            <button type="button" data-dismiss="alert" aria-label="Close" class="close"><span aria-hidden="true">�</span></button> <span class="font-weight-bold">Womp!</span> Vestibulum tincidunt ullamcorper eros eget luctus. Nulla porttitor libero.
                        </div>
                        <div role="alert" class="mt-1 alert alert-danger bg-danger text-white alert-dismissible fade show">
                            <button type="button" data-dismiss="alert" aria-label="Close" class="close"><span aria-hidden="true">�</span></button> <span class="font-weight-bold">Danger!</span> Vestibulum tincidunt ullamcorper eros eget luctus. Nulla porttitor libero.
                        </div>
                        <div role="alert" class="mt-1 alert alert-success bg-success alert-dismissible fade show">
                            <button type="button" data-dismiss="alert" aria-label="Close" class="close"><span aria-hidden="true">�</span></button> <span class="font-weight-bold">Success!</span> Vestibulum tincidunt ullamcorper eros eget luctus. Nulla porttitor libero.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> <span id="modals" class="anchor"></span>
    <section class="py-4 mt-2">
        <div class="row">
            <div class="col-md-12">
                <h2>Modals</h2>
                <h6 class="text-center text-wide mt-3">Examples</h6>
                <ul class="list-inline text-center">
                    <li class="list-inline-item py-1"><a href="" data-target="#myModal" data-toggle="modal" class="btn btn-outline-secondary btn-sm">Standard</a></li>
                    <li class="list-inline-item py-1"><a href="" data-target="#smallModal" data-toggle="modal" class="btn btn-outline-secondary btn-sm">Small</a></li>
                    <li class="list-inline-item py-1"><a href="" data-target="#largeModal" data-toggle="modal" class="btn btn-outline-secondary btn-sm">Large</a></li>
                </ul>
                <div id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" class="modal fade mt-5">
                    <div role="document" class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 id="myModalLabel" class="modal-title">Modal title</h4>
                                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">�</span></button>
                            </div>
                            <div class="modal-body">
                                <p>
                                    Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor. Aenean lacinia bibendum nulla sed consectetur. Praesent commodo cursus magna, vel scelerisque nisl consectetur et.
                                    Donec sed odio dui. Donec ullamcorper nulla non metus auctor fringilla. Cras mattis consectetur purus sit amet fermentum. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Morbi leo risus, porta ac consectetur
                                    ac, vestibulum at eros. Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor.
                                </p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" data-dismiss="modal" class="btn btn-secondary">Close</button>
                                <button type="button" class="btn btn-primary">Save changes</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div tabindex="-1" role="dialog" aria-hidden="true" id="smallModal" class="modal mt-5">
                    <div class="modal-dialog modal-sm">
                        <div class="modal-content text-center">
                            <div class="modal-body text-center">
                                <div role="alert" class="alert text-white bg-primary fade show"><span class="font-weight-bold">Womp!</span> There it is.
                                </div> <a data-dismiss="modal"><span aria-hidden="true" class="display-2">�</span></a></div>
                        </div>
                    </div>
                </div>
                <div tabindex="-1" role="dialog" aria-hidden="true" id="largeModal" class="modal fade mt-5">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content text-center p-3">
                            <div class="modal-body text-center">
                                <h1>Large Modal</h1>
                                <p class="lead">
                                    Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. Officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid
                                    single-origin coffee nulla assumenda shoreditch et. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore
                                    sustainable VHS.
                                </p>
                                <button type="button" data-dismiss="modal" class="btn btn-lg btn-primary mt-2 text-uppercase"><span aria-hidden="true">Close</span></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> <span id="tables" class="anchor"></span>
    <section class="py-4 mt-2">
        <div class="row">
            <div class="col-md-12">
                <h2>Tables</h2>
                <table class="table table-hover table-sm">
                    <thead>
                        <tr>
                            <th>Location</th>
                            <th>Points</th>
                            <th>Region</th>
                            <th class="text-right">Mean</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Newport, RI, USA</td>
                            <td>3</td>
                            <td>New England</td>
                            <td class="text-right">45001</td>
                        </tr>
                        <tr>
                            <td>Chicago, IL, USA</td>
                            <td>5</td>
                            <td>Mid West</td>
                            <td class="text-right">106455</td>
                        </tr>
                        <tr>
                            <td>New York, NY, USA</td>
                            <td>10</td>
                            <td>Mid Atlantic</td>
                            <td class="text-right">39097</td>
                        </tr>
                    </tbody>
                </table>
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered">
                        <thead>
                            <tr>
                                <th class="id"><a>Id <i class="fa fa-sort"></i></a></th>
                                <th class="name"><a>Name <i class="fa fa-sort"></i></a></th>
                                <th class="description">Description</th>
                                <th class="field3"><a>Link <i class="fa fa-sort"></i></a></th>
                                <th class="field4"><a>Reason <i class="fa fa-sort"></i></a></th>
                                <th class="field5"><a>Area <i class="fa fa-sort"></i></a></th>
                                <th class="text-center"><i class="ion-ios-trash-outline"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>alpha1</td>
                                <td>name 1</td>
                                <td>Description of item #1</td>
                                <td><a href="#" class="link">alpha</a></td>
                                <td>Some stuff about rec: 1</td>
                                <td>23</td>
                                <td class="text-center"><a href="">x</a></td>
                            </tr>
                            <tr>
                                <td>bob10</td>
                                <td>name 10</td>
                                <td>Description of item #10</td>
                                <td><a href="#" class="link">bob</a></td>
                                <td>Some stuff about rec: 10</td>
                                <td>22</td>
                                <td class="text-center"><a href="">x</a></td>
                            </tr>
                            <tr>
                                <td>daniel11</td>
                                <td>name 11</td>
                                <td>Description of item #11</td>
                                <td><a href="#" class="link">daniel</a></td>
                                <td>Some stuff about rec: 11</td>
                                <td>44</td>
                                <td class="text-center"><a href="">x</a></td>
                            </tr>
                            <tr>
                                <td>grace12</td>
                                <td>name 12</td>
                                <td>Description of item #12</td>
                                <td><a href="#" class="link">grace</a></td>
                                <td>Some stuff about rec: 12</td>
                                <td>19</td>
                                <td class="text-center"><a href="">x</a></td>
                            </tr>
                            <tr>
                                <td>alpha13</td>
                                <td>name 13</td>
                                <td>Description of item #13</td>
                                <td><a href="#" class="link">alpha</a></td>
                                <td>Some stuff about rec: 13</td>
                                <td>13</td>
                                <td class="text-center"><a href="">x</a></td>
                            </tr>
                            <tr>
                                <td>alpha14</td>
                                <td>name 14</td>
                                <td>Description of item #14</td>
                                <td><a href="#" class="link">alpha</a></td>
                                <td>Some stuff about rec: 14</td>
                                <td>14</td>
                                <td class="text-center"><a href="">x</a></td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="7">
                                    <div class="text-center">
                                        <nav aria-label="Page navigation">
                                            <ul class="pagination justify-content-center">
                                                <li class="page-item"><a href="" aria-label="Previous" class="page-link"><i class="fa fa-chevron-left ion-ios-arrow-left"></i> <span class="sr-only">Previous</span></a></li>
                                                <li class="page-item"><a href="" class="page-link">1</a></li>
                                                <li class="page-item"><a href="" class="page-link">2</a></li>
                                                <li class="page-item"><a href="" class="page-link">3</a></li>
                                                <li class="page-item"><a href="" class="page-link">4</a></li>
                                                <li class="page-item"><a href="" class="page-link">5</a></li>
                                                <li class="page-item"><a href="" aria-label="Next" class="page-link"><i class="fa fa-chevron-right ion-ios-arrow-right"></i> <span class="sr-only">Next</span></a></li>
                                            </ul>
                                        </nav>
                                    </div>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-inverse">
                                <tr>
                                    <th>Location</th>
                                    <th>Points</th>
                                    <th class="text-right">Mean</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Long Island, NY, USA</td>
                                    <td>7</td>
                                    <td class="text-right">45,001</td>
                                </tr>
                                <tr>
                                    <td>Chicago, Illinois, USA</td>
                                    <td>8</td>
                                    <td class="text-right">106,455</td>
                                </tr>
                                <tr>
                                    <td>New York, New York, USA</td>
                                    <td>4</td>
                                    <td class="text-right">39,097</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-sm-6">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-inverse">
                                <tr>
                                    <th>Location</th>
                                    <th>Points</th>
                                    <th class="text-right">Result</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Long Island, NY, USA</td>
                                    <td>1</td>
                                    <td class="text-right">5,001</td>
                                </tr>
                                <tr>
                                    <td>Chicago, Illinois, USA</td>
                                    <td>2</td>
                                    <td class="text-right">6,455</td>
                                </tr>
                                <tr>
                                    <td>New York, New York, USA</td>
                                    <td>3</td>
                                    <td class="text-right">9,097</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section> <span id="accordions" class="anchor"></span>
    <section class="py-4 mt-2">
        <div class="row">
            <div class="col-md-12">
                <h2>Accordions &amp; Collapsible</h2>
                <div class="row mt-2">
                    <div class="col-lg-6">
                        <div class="card card-default">
                            <h4 class="card-header"><a href="#" data-target="#collapseMe" data-toggle="collapse" class="float-right"><i class="align-middle fa fa-ellipsis-v"></i></a>
                                Heading
                            </h4>
                            <div id="collapseMe" class="collapse show card-body">
                                <p>Shiny, shiny. Varius azdipiscing elit. Duis pharetra codeply varius quam sit amet vulputate. Ovi lipsim diro? Then puska craft beer labore wes anderson cred nesciunt sapiente ea proident!</p>
                                <button class="btn btn-secondary">Take Action!</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div id="accordion2" class="accordion">
                            <div class="card">
                                <a data-toggle="collapse" href="#" data-target="#collapseOne2" class="card-header">
                                    <span class="card-title">
                                        Panel 1
                                    </span>
                                </a>
                                <div id="collapseOne2" class="card-body collapse show" data-parent="#accordion2">
                                    <p>Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt
                                        you probably haven't heard of them accusamus labore sustainable VHS.
                                    </p>
                                </div>
                                <a data-toggle="collapse" href="#" data-target="#collapseTwo2" class="card-header collapsed">
                                    <span class="card-title">
                                        Panel 2
                                    </span>
                                </a>
                                <div id="collapseTwo2" class="card-body collapse" data-parent="#accordion2">
                                    <p>Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. Officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor,
                                        sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher
                                        vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                                    </p>
                                </div>
                                <a data-toggle="collapse" href="#" data-target="#collapseThree2" class="card-header collapsed">
                                    <span class="card-title">
                                        Panel 3
                                    </span>
                                </a>
                                <div id="collapseThree2" class="card-body collapse" data-parent="#accordion2">
                                    <p>Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf
                                        moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. samus labore sustainable VHS.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> <span id="buttons" class="anchor"></span>
    <section class="py-4 mt-2">
        <div class="row h-100 align-items-center">
            <div class="col-12">
                <h2>Buttons</h2>
                <div class="row mt-2">
                    <div class="col-lg col-4">
                        <button class="btn btn-outline-primary mr-1">Primary</button>
                    </div>
                    <div class="col-lg col-4">
                        <button class="btn btn-outline-secondary mr-1">Secondary</button>
                    </div>
                    <div class="col-lg col-4">
                        <button class="btn btn-outline-info mr-1">Info</button>
                    </div>
                    <div class="col-lg col-4">
                        <button class="btn btn-outline-danger mr-1">Danger</button>
                    </div>
                    <div class="col-lg col-4">
                        <button class="btn btn-outline-success mr-1">Success</button>
                    </div>
                    <div class="col-lg col-4">
                        <button class="btn btn-outline-warning mr-1">Warning</button>
                    </div>
                    <div class="w-100 my-3"></div>
                    <div class="col-lg col-4">
                        <button class="btn btn-primary mr-1">Primary</button>
                    </div>
                    <div class="col-lg col-4">
                        <button class="btn btn-secondary mr-1">Secondary</button>
                    </div>
                    <div class="col-lg col-4">
                        <button class="btn btn-info mr-1">Info</button>
                    </div>
                    <div class="col-lg col-4">
                        <button class="btn btn-danger mr-1">Danger <span class="badge badge-light badge-pill">!</span></button>
                    </div>
                    <div class="col-lg col-4">
                        <button class="btn btn-success mr-1">Success</button>
                    </div>
                    <div class="col-lg col-4">
                        <button class="btn btn-warning mr-1">Warning</button>
                    </div>
                    <div class="w-100 my-3"></div>
                    <div class="col-xl col-4">
                        <button class="btn btn-lg btn-primary mr-1">Primary</button>
                    </div>
                    <div class="col-xl col-4">
                        <button class="btn btn-lg btn-secondary mr-1">Secondary</button>
                    </div>
                    <div class="col-xl col-4">
                        <button class="btn btn-lg btn-info mr-1">Info</button>
                    </div>
                    <div class="col-xl col-4">
                        <button class="btn btn-lg btn-danger mr-1">Danger</button>
                    </div>
                    <div class="col-xl col-4">
                        <button class="btn btn-lg btn-success mr-1">Success</button>
                    </div>
                    <div class="col-xl col-4">
                        <button class="btn btn-lg btn-warning mr-1">Warning</button>
                    </div>
                    <div class="w-100 my-3"></div>
                    <div class="col-lg col-4">
                        <button class="btn btn-sm btn-primary mr-1">Primary</button>
                    </div>
                    <div class="col-lg col-4">
                        <button class="btn btn-sm btn-secondary mr-1">Secondary</button>
                    </div>
                    <div class="col-lg col-4">
                        <button class="btn btn-sm btn-info mr-1">Info</button>
                    </div>
                    <div class="col-lg col-4">
                        <button class="btn btn-sm btn-danger mr-1">Danger</button>
                    </div>
                    <div class="col-lg col-4">
                        <button class="btn btn-sm btn-success mr-1">Success</button>
                    </div>
                    <div class="col-lg col-4">
                        <button class="btn btn-sm btn-warning mr-1">Warning</button>
                    </div>
                    <div class="w-100 my-3"></div>
                    <div class="col-lg col-3">
                        <div class="btn-group">
                            <button type="button" class="btn btn-secondary">Left</button>
                            <button type="button" class="btn btn-secondary">Middle</button>
                            <button type="button" class="btn btn-secondary">Right</button>
                        </div>
                    </div>
                    <div class="col-lg col-3">
                        <div class="dropdown">
                            <button type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-secondary dropdown-toggle">
                                Dropdown
                            </button>
                            <div aria-labelledby="dropdownMenuButton" class="dropdown-menu"><a href="#" class="dropdown-item">Action</a> <a href="#" class="dropdown-item">Another action</a> <a href="#" class="dropdown-item">Something else here</a></div>
                        </div>
                    </div>
                    <div class="col-lg col-3">
                        <div class="btn-group">
                            <button type="button" class="btn btn-secondary">Split</button>
                            <button type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-secondary dropdown-toggle dropdown-toggle-split"><span class="sr-only">Toggle Dropdown</span></button>
                            <div class="dropdown-menu"><a href="#" class="dropdown-item">Action</a> <a href="#" class="dropdown-item">Another action</a> <a href="#" class="dropdown-item">Something else here</a>
                                <div class="dropdown-divider"></div> <a href="#" class="dropdown-item">Separated link</a></div>
                        </div>
                    </div>
                    <div class="col-lg col-3">
                        <button type="button" class="btn btn-secondary btn-block">Block</button>
                    </div>
                </div>
            </div>
        </div>
    </section> <span id="badges" class="anchor"></span>
    <section class="py-4 mt-2">
        <div class="row">
            <div class="col-md-12">
                <h2>Badges</h2>
                <div class="row mt-2">
                    <div class="col-lg-3 pb-2">
                        <h6>Normal</h6> <a href=""><span class="badge badge-dark">badge</span></a> <a href=""><span class="badge badge-success">success</span></a> <a href=""><span class="badge badge-danger">danger</span></a>
                        <div class="w-100 my-3"></div> <a href=""><span class="badge badge-warning">warning</span></a> <a href=""><span class="badge badge-info">info</span></a> <a href=""><span class="badge badge-primary">primary</span></a>
                        <div class="w-100 my-3"></div> <a href=""><span class="badge badge-pill badge-dark">pill</span></a> <a href=""><span class="badge badge-pill badge-success">100k</span></a> <a href=""><span class="badge badge-pill badge-info">2</span></a>
                        <a href=""><span class="badge badge-pill badge-danger">378</span></a> <a href=""><span class="badge badge-pill badge-warning">tag</span></a> <a href=""><span class="badge badge-pill badge-primary">1123</span></a></div>
                    <div class="col-lg-4 pb-2">
                        <h5>Heading 5</h5>
                        <h5 class="mt-2"><a href=""><span class="badge badge-dark">badge</span></a> <a href=""><span class="badge badge-success">success</span></a> <a href=""><span class="badge badge-danger">danger</span></a> <div class="w-100 my-3"></div> <a href=""><span class="badge badge-warning">warning</span></a> <a href=""><span class="badge badge-info">info</span></a> <a href=""><span class="badge badge-primary">primary</span></a> <div class="w-100 my-3"></div> <a href=""><span class="badge badge-pill badge-dark">pill</span></a> <a href=""><span class="badge badge-pill badge-success">100k</span></a> <a href=""><span class="badge badge-pill badge-info">2</span></a> <a href=""><span class="badge badge-pill badge-danger">378</span></a> <a href=""><span class="badge badge-pill badge-warning">tag</span></a> <a href=""><span class="badge badge-pill badge-primary">1123</span></a></h5></div>
                    <div class="col-lg-5 pb-2">
                        <h3>Heading 3</h3>
                        <h3>
                            <a href=""><span class="badge badge-dark">badge</span></a>
                            <a href=""><span class="badge badge-success">success</span></a>
                            <a href=""><span class="badge badge-danger">danger</span></a>
                            <div class="w-100 my-3"></div>
                            <a href=""><span class="badge badge-warning">warning</span></a>
                            <a href=""><span class="badge badge-info">info</span></a>
                            <a href=""><span class="badge badge-primary">primary</span></a>
                            <div class="w-100 my-3"></div>
                            <a href=""><span class="badge badge-pill badge-dark">pill</span></a>
                            <a href=""><span class="badge badge-pill badge-success">100k</span></a>
                            <a href=""><span class="badge badge-pill badge-info">2</span></a>
                            <a href=""><span class="badge badge-pill badge-danger">378</span></a>
                            <a href=""><span class="badge badge-pill badge-warning">tag</span></a>
                            <a href=""><span class="badge badge-pill badge-primary">1123</span></a>
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="row">
            <div class="col-md-12">
                <h2>Breadcrumbs</h2>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Library</a></li>
                    <li class="breadcrumb-item active">Data</li>
                </ol>
            </div>
        </div>
    </section>
    <br>
</main>

<script>


    // prevent href=# click jump
    document.addEventListener("DOMContentLoaded", function () {
        var links = document.getElementsByTagName("A");
        for (var i = 0; i < links.length; i++) {
            if (links[i].href.indexOf('#') != -1) {
                links[i].addEventListener("click", function (e) {
                    console.debug("prevent href=# click");
                    if (this.hash) {
                        if (this.hash == "#") {
                            e.preventDefault();
                            return false;
                        } else {
                            /*
                             var el = document.getElementById(this.hash.replace(/#/, ""));
                             if (el) {
                             el.scrollIntoView(true);
                             }
                             */
                        }
                    }
                    return false;
                })
            }
        }
    }, false);
</script>

<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
