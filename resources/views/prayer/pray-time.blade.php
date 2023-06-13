<x-app-layouts meta-title="" meta-description="">
    
    <section class="container max-w-5xl mx-auto px-3">
        <article class="w-full shadow my-4">
            
            <script type="text/javascript" src="{{asset('js/PrayTimes.js')}}"></script>

            <div class="header">
                <form class="form" action="javascript:update();">
                    <span class="inline-block pr-1">Широта: <input class="border-y" type="text" value="43" id="latitude" size="5" onchange="update();" /></span>
                    <span class="inline-block pr-1">Долгота: <input class="border-y" type="text" value="-80" id="longitude" size="5" onchange="update();" /></span>
                    <span class="inline-block pr-1">Часовой пояс: <input class="border-y" type="text" value="-5" id="timezone" size="5" onchange="update();" /></span>
                    <!-- Daylight saving time -->
                    <span class="inline-block pr-1">
                        Переход на летнее время: 
                        <select id="dst" size="1" onchange="update()">
                            <option value="auto" selected="selected">Auto</option>
                            <option value="0">0</option>
                            <option value="1">1</option>
                        </select>&nbsp;
                    </span>
                    <span class="inline-block"> 
                        <select id="method" onchange="update()">
                            <option value="MWL" selected="selected">Muslim World League (MWL)</option>
                            <option value="ISNA">Islamic Society of North America (ISNA)</option>
                            <option value="Egypt">Egyptian General Authority of Survey</option>
                            <option value="Makkah">Umm al-Qura University, Makkah</option>
                            <option value="Karachi">University of Islamic Sciences, Karachi</option>
                            <option value="Jafari" selected>Shia Ithna-Ashari (Jafari)</option>
                            <option value="Tehran">Institute of Geophysics, University of Tehran</option>
                        </select>
                    </span>
                </form>
            </div>
            <br/>
            <table align="center">
            <tr>
                <td><a href="javascript:displayMonth(-1)" class="arrow">&lt;&lt;</a></td>
                <td id="table-title" class="caption"></td>
                <td><a href="javascript:displayMonth(+1)" class="arrow">&gt;&gt;</a></td>
            </tr>
            </table>
            
            <br/>
            <table id="timetable" class="timetable">
                <tbody></tbody>
            </table>
            
            <div align="center" style="margin-top: 7px">
                <!-- Source: <a href="http://praytimes.org/" class="command">PrayTimes.org</a> | -->
                Формат времени: <a id="time-format" value = '24-hour' href="javascript:switchFormat(1)" title="Change clock format" class="command"></a>
            </div>
            <br/>
            
            <script type="text/javascript">
            
                var currentDate = new Date();
                var timeFormat = 0; 
                switchFormat(0);
            
                // get lovation
                function initGeolocation(){
                if( navigator.geolocation ){
                        // Call getCurrentPosition with success and failure callbacks
                        navigator.geolocation.getCurrentPosition( success, fail );
                }else{
                        alert("Sorry, your browser does not support geolocation services.");
                    }
                }
            
                function success(position){
                    document.getElementById('longitude').value = position.coords.longitude;
                    document.getElementById('latitude').value = position.coords.latitude;
                    document.getElementById('timezone').value = -(new Date().getTimezoneOffset() / 60);
                    update();
                }
            
                function fail(){
                // Could not obtain location
                }
                // end get lovation
            
                // display monthly timetable
                function displayMonth(offset) {
                    onload=initGeolocation();
                    var lat = $('latitude').value;
                    var lng = $('longitude').value;
                    var timeZone = $('timezone').value;
                    var dst = $('dst').value;
                    var method = $('method').value;
            
                    prayTimes.setMethod(method);
                    currentDate.setMonth(currentDate.getMonth()+ 1* offset);
                    var month = currentDate.getMonth();
                    var year = currentDate.getFullYear();
                    var title = monthFullName(month)+ ' '+ year;
                    $('table-title').innerHTML = title;
                    makeTable(year, month, lat, lng, timeZone, dst);
                }
            
                // make monthly timetable
                function makeTable(year, month, lat, lng, timeZone, dst) {		
                    var items = {day: 'Day', fajr: 'Fajr', sunrise: 'Sunrise', 
                                dhuhr: 'Dhuhr', asr: 'Asr', // sunset: 'Sunset', 
                                maghrib: 'Maghrib', isha: 'Isha'};
                            
                    var tbody = document.createElement('tbody');
                    tbody.appendChild(makeTableRow(items, items, 'head-row'));
            
                    var date = new Date(year, month, 1);
                    var endDate = new Date(year, month+ 1, 1);
                    var format = timeFormat ? '12hNS' : '24h';
            
                    while (date < endDate) {
                        var times = prayTimes.getTimes(date, [lat, lng], timeZone, dst, format);
                        times.day = date.getDate();
                        var today = new Date(); 
                        var isToday = (date.getMonth() == today.getMonth()) && (date.getDate() == today.getDate());
                        var klass = isToday ? 'today-row' : '';
                        tbody.appendChild(makeTableRow(times, items, klass));
                        date.setDate(date.getDate()+ 1);  // next day
                    }
                    removeAllChild($('timetable'));
                    $('timetable').appendChild(tbody);
                }
            
                // make a table row
                function makeTableRow(data, items, klass) {
                    var row = document.createElement('tr');
                    for (var i in items) {
                        var cell = document.createElement('td');
                        cell.innerHTML = data[i];
                        cell.style.width = i=='day' ? '2.5em' : '3.7em';
                        row.appendChild(cell);
                    }
                    row.className = klass;
                    return row;		
                }
            
                // remove all children of a node
                function removeAllChild(node) {
                    if (node == undefined || node == null)
                        return;
            
                    while (node.firstChild)
                        node.removeChild(node.firstChild);
                }
            
                // switch time format
                function switchFormat(offset) {
                    var formats = ['24-часовой', '12-часовой'];
                    timeFormat = (timeFormat+ offset)% 2;
                    $('time-format').innerHTML = formats[timeFormat];
                    update();
                }
            
                // update table
                function update() {
                    displayMonth(0);
                }
            
                // return month full name
                function monthFullName(month) {
                    var monthName = new Array('Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 
                                    'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь');
                    return monthName[month];
                }
            
                function $(id) {
                    return document.getElementById(id);
                }
            
            
            </script>
        </article>
    </section>
</x-app-layouts>
    {{-- </html> --}}
    
    
    
    





