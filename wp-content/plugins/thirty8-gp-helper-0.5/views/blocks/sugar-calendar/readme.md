# Notes on SugarCalendar rendering tests...

## 19/04/23

### Full calendar	
- I played with having fullcalendar displaying things but the recurrence of events is gonna be really truly horrible, so I gave it up. 
- If you do want to try it, just replace this block page with the fullcalendar-test.php code
- The basic display works beautifully, but recurrence is going to mean having to sub-loop through all events marked as recurring and I can sense this is gunna be awful 
- ...so have given up for now

### Querying using wp-query
- Also played with hitting up events using a custom loop
- This might come in handy - code is in wpquery-tests.php