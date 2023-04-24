import {useState} from "react";
import {useUserContext} from "@/components/Context/UserContext";

const useCreateUserModel = () => {
    const [isModalOpen, setIsModalOpen] = useState(false);

    const handleOpenModal = () => setIsModalOpen(true);
    const handleCloseModal = () => setIsModalOpen(false);

    return {
        handleOpenModal,
        handleCloseModal,
        isModalOpen,
        setIsModalOpen
    }
};

const useCreateUser = ({handleClose}) => {
    const { createUser } = useUserContext();

    const [email, setEmail] = useState('');
    const [firstName, setFirstName] = useState('');
    const [lastName, setLastName] = useState('');

    const handleSubmit = () => {
        createUser({email,firstName,lastName});
        handleClose();
    };
    return {handleSubmit, email, setEmail, firstName, setFirstName,lastName, setLastName}
};

const useValidateUserCreation = ({handleSubmit,email, firstName, lastName}) => {
    const [errors, setErrors] = useState({ email: '', firstName: '', lastName: '' });

    const validate = () => {
        let isValid = true;
        const newErrors = { email: '', firstName: '', lastName: '' };

        if (!email) {
            newErrors.email = 'Email is required';
            isValid = false;
        } else if (!/\S+@\S+\.\S+/.test(email)) {
            newErrors.email = 'Email is invalid';
            isValid = false;
        }

        if (!firstName) {
            newErrors.firstName = 'First name is required';
            isValid = false;
        }

        if (!lastName) {
            newErrors.lastName = 'Last name is required';
            isValid = false;
        }

        setErrors(newErrors);
        return isValid;
    };

    const handleSave = () => {
        if (validate()) {
            handleSubmit();
        }
    };
    return {handleSave, errors}
};

export {
    useCreateUserModel,
    useCreateUser,
    useValidateUserCreation
};