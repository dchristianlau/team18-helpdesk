<?php

require ($_SERVER['DOCUMENT_ROOT'] . "/resources/page/page.php");

if ($employee === null)
{
    header ('Location: /users/login.php');
    exit;
}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <?php include(INCLUDE_META) ?>
        
        <title>Team 18 Helpdesk - View Tickets</title>
        
        <meta name="description" content="View all open, pending and closed tickets as an overview.">
        
        <?php include(INCLUDE_STYLE) ?>
        
        <style>
            .filter-pending
            {
                font-weight: bold;
                color: #e44;
            }
            
            .filter-open
            {
                font-weight: bold;
                color: #4e4;
            }
            
            .filter-closed
            {
                font-weight: bold;
                color: #44e;
            }
        </style>
        
        <?php include(INCLUDE_SCRIPTS) ?>
        
        <script>
            'use strict';

            var getTickets = function getTickets() {
                var options = {
                    sort: document.querySelector('[name=sorting]:checked').value,
                    descendingOrder: document.querySelector('[name=order]').checked,
                    showPending: document.querySelector('[name=show-pending]').checked,
                    showOpen: document.querySelector('[name=show-open]').checked,
                    showClosed: document.querySelector('[name=show-closed]').checked
                };

                var http = new XMLHttpRequest() || new ActiveXObject('Microsoft.XMLHTTP');

                http.onreadystatechange = function () {
                    if (http.readyState === XMLHttpRequest.DONE) {
                        if (http.status === 200) {
                            var response = http.responseText;

                            document.querySelector('.tickets-container').innerHTML = response;
                        }
                    }
                };

                var parameters = '?sort=' + options.sort + '&order=' + options.descendingOrder + '&pending=' + options.showPending + '&open=' + options.showOpen + '&closed=' + options.showClosed;

                http.open('GET', 'get-tickets.php' + parameters, true);

                http.send();
            };

            window.addEventListener('load', getTickets);

            window.addEventListener('load', function () {
                var ticketInputs = Array.from(document.querySelectorAll('.tickets-input'));

                ticketInputs.forEach(function (input) {
                    input.addEventListener('change', getTickets);
                });
            });
        </script>
    </head>
    
    <body>
        <?php include(INCLUDE_HEADER) ?>
        <nav role="navigation" class="padding-small clearfix">
            <div class="float-left">
                <a href="/overview.php">&larr; Return to Overview page</a>
            </div>
            <div class="float-right">
            </div>
        </nav>
        <div class="content-width clearfix">
            <div class="sidebar float-left padding-small">
                <div class="section bg-white shadow">
                    <div class="content-section padding-small">
                        <h2>Sort and Filter</h2>
                        <h3>Sorting</h3>
                        <p>
                            <input class="tickets-input" type="radio" name="sorting" value="0" checked>
                            <span>Creation Date</span>
                        </p>
                        <p>
                            <input class="tickets-input" type="radio" name="sorting" value="1">
                            <span>Ticket ID</span>
                        </p>
                        <p>
                            <input class="tickets-input" type="radio" name="sorting" value="2">
                            <span>Priority</span>
                        </p>
                        <p>
                            <input class="tickets-input" type="checkbox" name="order" checked>
                            <span>Descending Order</span>
                        </p>
                    </div>
                    <div class="padding-small content-section">
                        <h3>Filters</h3>
                        <p>
                            <input class="tickets-input" type="checkbox" name="show-pending" checked>
                            <span class="filter-pending">Show Pending Tickets</span>
                        </p>
                        <p>
                            <input class="tickets-input" type="checkbox" name="show-open" checked>
                            <span class="filter-open">Show Open Tickets</span>
                        </p><p>
                            <input class="tickets-input" type="checkbox" name="show-closed" checked>
                            <span class="filter-closed">Show Closed Tickets</span>
                        </p>
                    </div>
                </div>
                <div class="section bg-white shadow">
                    <div class="content-section padding-small">
                        <h2>Actions</h2>
                        <p><a href="/create-ticket/"><button>Create a New Ticket</button></a></p>
                    </div>
                </div>
            </div>
            <div class="main-content padding-small">
                <div class="padding-small bg-white shadow">
                    <h2>Tickets</h2>
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Short Summary</th>
                                <th>Date Created</th>
                                <th>Status</th>
                                <th>Priority</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody class="tickets-container"></tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php include(INCLUDE_FOOTER) ?>
    </body>
</html>