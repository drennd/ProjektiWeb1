window.weatherWidgetConfig =  window.weatherWidgetConfig || [];
               window.weatherWidgetConfig.push({
                   selector:".weatherWidget",
                   apiKey:"LA5Q2JMS3QTJPC9T8WVTBXG7R", //Sign up for your personal key
                   location:"Tirana, Albania", //Enter an address
                   unitGroup:"metric", //"us" or "metric"
                   forecastDays: 3, //how many days forecast to show
                   title:"Tirana, Albania", //optional title to show in the 
                   showTitle:true, 
                   showConditions:true
               });
              
               (function() {
               var d = document, s = d.createElement('script');
               s.src = 'https://www.visualcrossing.com/widgets/forecast-simple/weather-forecast-widget-simple.js';
               s.setAttribute('data-timestamp', +new Date());
               (d.head || d.body).appendChild(s);
               })();