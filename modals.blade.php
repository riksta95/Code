<!-- Visitor Modal -->
<div id="visitor-more-info-modal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-body">
                <hr>
                <h4 style="font-weight: 600;">
                    <i class="fa fa-ticket"></i>&nbsp;Visitor Ticket
                </h4>
                <hr>
                <p class="mt-3">
                    <strong>Date:</strong> 10 - 12 March 2020
                </p>
                <p>
                    <strong>Location:</strong> Olympia London
                </p>
                <p>
                    <strong>Price:</strong>
                    @if(earlyBirdCheck('visitor'))
                        &pound;50 for all three days of the fair (Online Early Bird price)
                    @else
                        &pound;60 for all three days of the fair
                    @endif
                </p>
                <p class="mb-0">
                    <strong>On the door:</strong> &pound;60 on the day booking for all three days
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Ok</button>
            </div>
        </div>
    </div>
</div>

<!-- Priority Access Modal -->
<div id="p-access-more-info-modal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-body">
                <hr>
                <h4 style="font-weight: 600;">
                    <i class="fa fa-clock-o"></i>&nbsp;Priority Access
                </h4>
                <hr>
                <p class="mt-3">
                    Priority access allows entrance to The London Book Fair exhibition at 8:30am for each morning of
                    the Fair (10th - 12th March 2020), and includes a free coffee and pastry from the High Street
                    Caf&eacute; between 8:30am - 9:30am. Non priority visitor ticket holders will only be allowed entrance
                    at 9:00am.
                </p>
                <p class="mb-0">
                    <strong>Price:</strong> &pound;110 (including the general visitor ticket price).
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Ok</button>
            </div>
        </div>
    </div>
</div>

<!-- Introduction to Rights Modal -->
<div id="rights-more-info-modal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-body">
                <hr>
                <h4 style="font-weight: 600;">
                    <i class="fa fa-users"></i>&nbsp;Introduction to Rights Conference
                </h4>
                <hr>
                <p class="mt-3">
                    <strong>Date:</strong> Monday 9 March 2020
                </p>
                <p>
                    <strong>Time:</strong> 12:45 - 18:00
                </p>
                <p>
                    <strong>Location:</strong> Olympia Conference Centre, London Apex Room, Olympia London
                </p>
                <p>
                    <strong>Price:</strong>
                    @if(focVisitor() == 'student')
                        &pound;10 inc VAT
                    @else
                        &pound;140 exc VAT
                    @endif
                </p>
                <p class="mb-0">
                    <strong>This option includes a FREE Visitor Ticket to The London Book Fair 10-12 March</strong>
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Ok</button>
            </div>
        </div>
    </div>
</div>

<!-- What Works Modal -->
<div id="ww-more-info-modal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-body">
                <hr>
                <h4 style="font-weight: 600;">
                    <i class="fa fa-users"></i>&nbsp;What Works? Education Conference
                </h4>
                <hr>
                <p class="mt-3">
                    <strong>Date:</strong> Tuesday 10 March 2020
                </p>
                <p>
                    <strong>Time:</strong> 09:30 - 13:00
                </p>
                <p>
                    <strong>Location:</strong> Olympia Conference Centre, London Apex Room, Olympia London
                </p>
                <p>
                    <strong>Price:</strong>
                    @if(focVisitor() == 'student')
                        &pound;10 inc VAT
                    @elseif(earlyBirdCheck('ww'))
                        &pound;149 + VAT (Online Early Bird price)
                    @else
                        &pound;199 + VAT
                    @endif
                </p>
                <p class="mb-0">
                    <strong>This option includes a FREE Visitor Ticket to The London Book Fair 10-12 March</strong>
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Ok</button>
            </div>
        </div>
    </div>
</div>

<!-- Writers Summit Modal -->
<div id="writers-summit-more-info-modal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-body">
                <hr>
                <h4 style="font-weight: 600;">
                    <i class="fa fa-users"></i>&nbsp;Writers Summit @ LBF
                </h4>
                <hr>
                <p class="mt-3">
                    <strong>Date:</strong> Tuesday 10 March 2020
                </p>
                <p>
                    <strong>Time:</strong> 09:30 - 13:00
                </p>
                <p>
                    <strong>Location:</strong> Pergola Olympia London
                </p>
                <p>
                    <strong>Price:</strong>
                    @if(focVisitor() == 'student')
                        &pound;10 inc VAT
                    @elseif(earlyBirdCheck('writers-summit'))
                        &pound;149 + VAT (Online Early Bird price)
                    @else
                        &pound;199 + VAT
                    @endif
                </p>
                <p class="mb-0">
                    <strong>This option includes a FREE Visitor Ticket to The London Book Fair 10-12 March</strong>
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Ok</button>
            </div>
        </div>
    </div>
</div>

<!-- Research & Scholarly Publishing Forum Modal -->
<div id="forum-more-info-modal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-body">
                <hr>
                <h4 style="font-weight: 600;">
                    <i class="fa fa-users"></i>&nbsp;Research &amp; Scholarly Publishing Forum
                </h4>
                <hr>
                <p class="mt-3">
                    <strong>Date:</strong> Wednesday 11 March 2020
                </p>
                <p>
                    <strong>Time:</strong> 09:30 - 13:00
                </p>
                <p>
                    <strong>Location:</strong> Olympia Conference Centre, London
                </p>
                <p>
                    <strong>Price:</strong>
                    @if(focVisitor() == 'student')
                        &pound;10 inc VAT
                    @elseif(earlyBirdCheck('forum'))
                        &pound;149 + VAT (Online Early Bird price)
                    @else
                        &pound;199 + VAT
                    @endif
                </p>
                <p class="mb-0">
                    <strong>This option includes a FREE Visitor Ticket to The London Book Fair 10-12 March</strong>
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Ok</button>
            </div>
        </div>
    </div>
</div>
