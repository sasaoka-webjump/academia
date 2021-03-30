
async function callLogin() {
    try {
        const response = await axios.get('http://localhost:8000/', {
            header: {
                Authorization: 'Basic ' + btoa('teste:@55w0rd');
            }
        });
        
        const rootDiv = document.getElementById('root');

        rootDiv.innerHTML = response.data.message;

    } catch (error) {
        console.error(error);
    }
}

(async () => {
    
    await callLogin();
})();
