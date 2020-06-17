# Scope Covered

- Simulation on clicking Next week button
- Simulation on clicking Play All
- Prediction for each team from 4th week
- Edit for match results for each week
- Reset of data
- PHPUnit tests
- Responsiveness application
- Implementation of translation for displaying data

# Technology Stack

- PHP >= 7.2
- MySQL
- Laravel
- Vue.js
- Tailwind css

# Good to know notes

- ## League Rules

    a. If team won : 3 points.

    b. If team draw : 1 point for each team.

    c. If team lost : 0 point.
    
    d. GD : Subtraction between goals scored and goals conceded (i.e.  difference of <goals scored> - <goal conceded> in all matches).
    
    e. 2 matches per week: As most of the premier league matches are on saturday and sunday afternoons.

    f. League duration: It will be in a number of weeks. It depends on the number of teams. For e.g.,  If we have four teams then total number of matches played will be 12 (i.e. each team will play with other team twice [Home,Away match] ) that means there will be 6 weeks. 


- ## Data generation

    - Seeders are written for generation of data
    - Matches among the teams are defined randomly with respect to the defined rules.
    - For current scope, 4 teams are considered.

- ## Prediction

    Formula used for prediction for each team for desired week is as below:

    a. Calculate the win, draw, lost, points probability for each team using below formula:
    
        winProbability = [No. of matches won] / [No. of matches played], provided that [No. of matches won] > 0
        drawProbability = [No. of matches draw] / [No. of matches played], provided that [No. of matches draw] > 0
        lossProbability = [No. of matches lost] / [No. of matches played], provided that [No. of matches lost] > 0
        totalPointsProbability = [No. of current points] / [No. of total points if all the so far played matches are won], provided that [No. of current points] > 0

    b. Calculate total probability for each team using below formula:
    
        probability = winProbability * drawProbability * lossProbability * totalPointsProbability

    c. Sum up the total probability of each team:
    
        totalProbability  = [probability of team 1] + [probability of team 2] + ... + [probability of team N], where N is the number of teams

    d. Calculate the percentage prediction for each team using below formula:
    
        ([teamProbability] / [totalProbability]) * 100, where
        
        - [teamProbability] = The probability of the team calculated in step b.
        - [totalProbability] = The total probability of all the teams calculated in step c.

- ## Next week feature

    Clicking on the button, the results of the next week are displayed. In case the next week matches are not played already, then the same are first simulated randomly and then the results are displayed.

- ## PlayAll feature

    Clicking on the button, the results of all the weeks are displayed. In case, the weeks' matches are not played already, then the same are first simulated randomly and then the results are displayed.

- ## Edit feature
    
    Clicking the button, end user can edit the match results (i.e. goals) which have been played on that particular week. On clicking save, results of both the matches played within the same week are updated and the UI is refreshed with updated data.

- ## Reset feature

    Clicking the button, all the played matches data is flushed and random data for first week is generated and displayed to client.

- ## Configurable options

    Following are the configurable:
    - No. of week from where the prediction needs to be displayed (```config/simulation.php``` => within key name: ```showFrom``` within ```predictions```)
    
    - No. of min and max goals a team can score during the match (```config/simulation.php``` => within key name: ```min```, ```max``` respectively within ```goals```)
    
    - No. of points to assign to team on winning, lossing or when match is draw. (```config/simulation.php``` => within key name: ```win```, ```draw```, ```loss``` respectively within ```points```)
