import { useHistory } from "react-router-dom";


const Logout = () => {
    localStorage.clear();
    const history = useHistory();

    history.push('/login');

    return(<></>);
};

export default Logout;
