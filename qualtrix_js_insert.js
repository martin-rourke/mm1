//////////////////////////////////
//
// START OF COMMON FUNCTIONS  
//
//  I'm hoping you can add these into the js area of the question??  If not we can add to the main code, just let me know and I'll do it
//
//////////////////////////////////

function getParameterByName(name, url = window.location.href) {
    name = name.replace(/[\[\]]/g, '\\$&');
    var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, ' '));
}

function isValidJson(json) {
    try {
        JSON.parse(json);
        return true;
    } catch (e) {
        return false;
    }
}

//////////////////////////////////
//
// END OF COMMON FUNCTIONS
//
//////////////////////////////////

//////////////////////////////////
//
// Insert the following into the Qualtrics.SurveyEngine.addOnLoad function, not sure how you substitute values in the question, I've taken a look online and
// jquery is used.  Let me know if you need me to look at, but without access to Qualtrix with js enabled, I have my hands tied a bit.  
//
//////////////////////////////////



    moduleData_json = getParameterByName('moduleData');
    
    console.log(moduleData_json);
    
    
    if ( isValidJson(moduleData_json) ) {
        
        var moduleData = JSON.parse(moduleData_json);
        

    
        if ( moduleData !== null ) {
        
            if (typeof(moduleData.Title) !== 'undefined') {
                var title = moduleData.Title;
              
                console.log('Module Title = ' + title);
            } else {
                console.log('Module Title is empty');
            }
        
            if (typeof(moduleData.Code) !== 'undefined') {
                var code = moduleData.Code;
                                                          
                console.log('Module Code = ' + code);
            } else {
                console.log('Module Code is empty');
            }
        
            if (typeof(moduleData.SSS) !== 'undefined') {
                var SSS = moduleData.SSS;
              
                console.log('Subject Specific Skills = ' + SSS );
            } else {
                console.log('Subject Specific Skills');
            }
                
            if (typeof(moduleData.LOs) !== 'undefined') {
                var LOs = moduleData.LOs;
              
                console.log('Learning Outcomes - ');
                for (i = 0; i < LOs.length; i++) {
                    console.log(LOs[i]);
                }
            } else {
                console.log('Learning Outcomes is empty');
            }
        }
        
    } else {
        console.log('Malformed JSON string passed, cannot process!');
    }
