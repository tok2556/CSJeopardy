<div class="app">

	<header class="top-header">
		<h1>CSJeopardy!</h1>
    	<p class="score">Score <span class="score-count"></span></p>
   	</header>
   
   <!-- container for the board -->
    <div class="board">
       <!-- categories get injected here -->
    </div>
   
   	<!-- invisible container for the card prompt -->
    <div class="card-modal">
       <div class=card-modal-inner>
          <h2 class="clue-text"><!-- clue gets injected here --></h2>
          	<form autocomplete="off">
            	<input name="user-answer" type="text" />
             	<button type="submit">Answer</button>
          	</form>
          	<div class="result">
             	<p class="result_success">CORRECT</p>
             	<p class="result_fail">INCORRECT</p>
             	<p class="result_correct-answer">
                The correct answer is <span class="result_correct-answer-text"><!--answer gets injected here--></span>
             	</p>
          	</div>
       	</div>
    </div>
</div>
    <style>
		:root {
   --blue: linear-gradient(180deg, #0120CB 0%, #011BA9 100%);
   --yellow: #FFE817;
   --green: #90FF7E;
   --red: #FFA57E;
   --spooky-orange: #ad4e08;
   --spooky-orange-text: #fffec8;
   --gap: 0.1em;
   --text-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);
}

* {
   box-sizing: border-box;
}

html, body {
   height: 100%;
}

body {
   font-family: sans-serif;
   // background: #222;
   color: white;
   font-size: 2vw;
   text-align: center;
   padding: 1em;
   background: linear-gradient(180deg, #2E2E3A 0%, #0C0C2C 100%);
}

.top-header {
   display: flex;
   justify-content: space-between;
   align-items: center;
   text-shadow: var(--text-shadow);
}
.score {
   display: flex;
   align-items: center;
}
.score-count {
   color: var(--yellow);
   font-size: 2em;
   font-weight:bold;
   margin-left: 0.2em;
}

.column ul {
   list-style-type: none;
   margin: 0;
   padding: 0;
}
.board {
   display: flex;
   justify-content: space-around;
}
.board .column {
   flex: 1;
   margin-left: var(--gap);
   margin-right: var(--gap);
}
.board .column header {
   text-transform: capitalize;
   background: var(--blue);
   text-align: center;
   margin-bottom: 1em;
   height: 3em;
   display: flex;
   align-items: center;
   justify-content: center;
}
.board .column li {
   background: var(--blue);
   color: var(--yellow);
   height: 3em;
   margin-bottom: 0.25em;
}
.board .column button {
   height: 100%;
   color: inherit;
   font-size: 2em;
   -webkit-appearance: none;
   border: 0;
   background: none;
   display: block;
   width: 100%;
   cursor: pointer;
   text-shadow: var(--text-shadow);
   font-weight:bold;
}
.board .column button.used {
   visibility: hidden;
}

.card-modal {
   opacity: 0;
   pointer-events:none;
   transition: opacity 0.4s;
   left: 0;
   right: 0;
   top: 0;
   bottom: 0;
   background: var(--blue);
   position: fixed;
   font-size: 2vw;
   text-align: center;
   display: flex;
   align-items: center;
   justify-content: center;
}
.card-modal.visible {
   opacity: 1;
   pointer-events:initial;
}
.card-modal.showing-result .result {
   display:block;
}

.card-model .clue-text {
   margin-bottom: 2em;
}

.result,
.card-modal.showing-result form {
   display:none;
}

.card-modal form {
   display: flex;
}
.card-modal form input[type="text"] {
   display: block;
   flex-grow: 1;
   height: 3em;
   line-height: 3em;
   border: 0;
   text-align: center;
   border-top-left-radius: 0.4em;
   border-bottom-left-radius: 0.4em;
}
.card-modal form button[type="submit"] {
   padding-left: 2em;
   padding-right: 2em;
   cursor: pointer;
   font-family: inherit;
   background: var(--yellow);
   border: 0;
   font-size: inherit;
   border-top-right-radius: 0.4em;
   border-bottom-right-radius: 0.4em;
}
.card-modal-inner {
   width: 60%;
   text-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);
}

.result_success, .result_fail {
   font-size: 2em;
   font-weight:bold;
}
.result_success {
   color: var(--green);
}
.result_fail {
   color: var(--red);
}
.result_correct-answer-text {
   font-weight:bold;
   font-size: 2em;
   display:block;
   margin-left: 0.1em;
}
	</style>
        
		<script>
			class TriviaGameShow {
   				constructor(element, options={}) {
      
      			//Which categories we should use (or use default is nothing provided)
      			this.useCategoryIds = options.useCategoryIds || [ 1892, 4483, 88, 218]; 
    
      //Database
      this.categories = [];
      this.clues = {};
      
      //State
      this.currentClue = null;
      this.score = 0;
      
      //Elements
      this.boardElement = element.querySelector(".board");
      this.scoreCountElement = element.querySelector(".score-count");
      this.formElement = element.querySelector("form");
      this.inputElement = element.querySelector("input[name=user-answer]");
      this.modalElement = element.querySelector(".card-modal");
      this.clueTextElement = element.querySelector(".clue-text");
      this.resultElement = element.querySelector(".result");
      this.resultTextElement = element.querySelector(".result_correct-answer-text");
      this.successTextElement = element.querySelector(".result_success");
      this.failTextElement = element.querySelector(".result_fail");
   }

   initGame() {
      //Bind event handlers
      this.boardElement.addEventListener("click", event => {
         if (event.target.dataset.clueId) {
            this.handleClueClick(event);
         }
      });
      this.formElement.addEventListener("submit", event => {
         this.handleFormSubmit(event);
      });
      
      //Render initial state of score
      this.updateScore(0);
      
      //Kick off the category fetch
      this.fetchCategories();
   }
   

   fetchCategories() {      
      //Fetch all of the data from the API
      const categories = this.useCategoryIds.map(category_id => {
         return new Promise((resolve, reject) => {
            fetch(`https://jservice.io/api/category?id=${category_id}`)
               .then(response => response.json()).then(data => {
                  resolve(data);
               });
         });
      });
      
      //Sift through the data when all categories come back
      Promise.all(categories).then(results => {
         
         //Build up our list of categories
         results.forEach((result, categoryIndex) => {
            
            //Start with a blank category
            var category = {
               title: result.title,
               clues: []
            }
            
            //Add every clue within a category to our database of clues
            var clues = shuffle(result.clues).splice(0,5).forEach((clue, index) => {
               console.log(clue)
               
               //Create unique ID for this clue
               var clueId = categoryIndex + "-" + index;
               category.clues.push(clueId);
               
               //Add clue to DB
               this.clues[clueId] = {
                  question: clue.question,
                  answer: clue.answer,
                  value: (index + 1) * 100
               };
            })
            
            //Add this category to our DB of categories
            this.categories.push(category);
         });
         
         //Render each category to the DOM
         this.categories.forEach((c) => {
            this.renderCategory(c);
         });
      });
   }

   renderCategory(category) {      
      let column = document.createElement("div");
      column.classList.add("column");
      column.innerHTML = (
         `<header>${category.title}</header>
         <ul>
         </ul>`
      ).trim();
      
      var ul = column.querySelector("ul");
      category.clues.forEach(clueId => {
         var clue = this.clues[clueId];
         ul.innerHTML += `<li><button data-clue-id=${clueId}>${clue.value}</button></li>`
      })
      
      //Add to DOM
      this.boardElement.appendChild(column);
   }

   updateScore(change) {
      this.score += change;
      this.scoreCountElement.textContent = this.score;
   }

   handleClueClick(event) {
      var clue = this.clues[event.target.dataset.clueId];

      //Mark this button as used
      event.target.classList.add("used");
      
      //Clear out the input field
      this.inputElement.value = "";
      
      //Update current clue
      this.currentClue = clue;

      //Update the text
      this.clueTextElement.textContent = this.currentClue.question;
      this.resultTextElement.textContent = this.currentClue.answer;

      //Hide the result
      this.modalElement.classList.remove("showing-result");
      
      //Show the modal
      this.modalElement.classList.add("visible");
      this.inputElement.focus();
   }

   //Handle an answer from user
   handleFormSubmit(event) {
      event.preventDefault();
      
      var isCorrect = this.cleanseAnswer(this.inputElement.value) === this.cleanseAnswer(this.currentClue.answer);
      if (isCorrect) {
         this.updateScore(this.currentClue.value);
      }
      
      //Show answer
      this.revealAnswer(isCorrect);
   }
   
   //Standardize an answer string so we can compare and accept variations
   cleanseAnswer(input="") {
      var friendlyAnswer = input.toLowerCase();
      friendlyAnswer = friendlyAnswer.replace("<i>", "");
      friendlyAnswer = friendlyAnswer.replace("</i>", "");
      friendlyAnswer = friendlyAnswer.replace(/ /g, "");
      friendlyAnswer = friendlyAnswer.replace(/"/g, "");
      friendlyAnswer = friendlyAnswer.replace(/^a /, "");
      friendlyAnswer = friendlyAnswer.replace(/^an /, "");      
      return friendlyAnswer.trim();
   }
   
   
   revealAnswer(isCorrect) {
      
      //Show the individual success/fail case
      this.successTextElement.style.display = isCorrect ? "block" : "none";
      this.failTextElement.style.display = !isCorrect ? "block" : "none";
      
      //Show the whole result container
      this.modalElement.classList.add("showing-result");
      
      //Disappear after a short bit
      setTimeout(() => {
         this.modalElement.classList.remove("visible");
      }, 3000);
   }
   
}
	
function shuffle(a) {
    var j, x, i;
    for (i = a.length - 1; i > 0; i--) {
        j = Math.floor(Math.random() * (i + 1));
        x = a[i];
        a[i] = a[j];
        a[j] = x;
    }
    return a;
} 

const game = new TriviaGameShow( document.querySelector(".app"), {});
game.initGame();


</script>
