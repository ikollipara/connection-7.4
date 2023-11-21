/*
|--------------------------------------------------------------------------
| Create.jsx 
|--------------------------------------------------------------------------
|
| Registration Creation Form.
*/

import { Layout } from "../../components/Layout";
import { useForm } from "@inertiajs/react";
import { useState } from "react";
import Input from "../../components/forms/Input";
import Password from "../../components/forms/Password";
import SlimSelectComponent from "../../components/forms/SlimSelect";
import File from "../../components/forms/File";
import Editor from "../../components/forms/Editor";

function Step({ show, children }) {
    return <section hidden={show}>{children}</section>;
}

export default function Create() {
    const [step, setStep] = useState(1);
    const { data, setData, errors, processing, post } = useForm({
        first_name: "",
        last_name: "",
        email: "",
        school: "",
        subject: "",
        grades: [],
        avatar: null,
        password: "",
        bio: { blocks: [] },
        password_confirmation: "",
    });

    function submit(e) {
        e.preventDefault();
        post(route("register"));
    }

    return (
        <Layout title="ConneCTION - Sign Up">
            {Object.keys(errors).length > 0 && (
                <div className="notification is-danger">
                    There was an error with your submission.
                </div>
            )}
            <form onSubmit={submit}>
                <Step show={step === 1}>
                    <h2 className="subtitle is-3 has-text-centered">
                        Personal Information
                    </h2>
                    <Input
                        label={"First Name"}
                        name={"first_name"}
                        value={data.first_name}
                        onChange={(e) => setData("first_name", e.target.value)}
                        error={errors.first_name}
                    />
                    <Input
                        label={"Last Name"}
                        name={"last_name"}
                        value={data.last_name}
                        onChange={(e) => setData("last_name", e.target.value)}
                        error={errors.last_name}
                    />
                    <Input
                        label={"Email"}
                        name={"email"}
                        type="email"
                        value={data.email}
                        onChange={(e) => setData("email", e.target.value)}
                        error={errors.email}
                    />
                    <div className="field is-grouped is-grouped-centered">
                        <div className="control">
                            <button
                                onClick={() => setStep(step++)}
                                type="button"
                                className="button is-primary"
                            >
                                Next
                            </button>
                        </div>
                    </div>
                </Step>
                <Step show={step === 2}>
                    <h2 className="subtitle is-3 has-text-centered">
                        School Information
                    </h2>
                    <Input
                        label={"School"}
                        name={"school"}
                        value={data.school}
                        onChange={(e) => setData("school", e.target.value)}
                        error={errors.school}
                    />
                    <Input
                        label={"Subject"}
                        name={"subject"}
                        value={data.subject}
                        onChange={(e) => setData("subject", e.target.value)}
                        error={errors.subject}
                    />
                    <SlimSelectComponent
                        multiple
                        placeholder={"Select Grades"}
                        options={[
                            "Kindergarten",
                            "1st",
                            "2nd",
                            "3rd",
                            "4th",
                            "5th",
                            "6th",
                            "7th",
                            "8th",
                            "9th",
                            "10th",
                            "11th",
                            "12th",
                        ]}
                        events={{
                            afterChange: (info) => {
                                setData(
                                    "grades",
                                    info.map((i) => i.value)
                                );
                            },
                        }}
                    />
                    <div className="field is-grouped is-grouped-centered">
                        <div className="control">
                            <button
                                onClick={() => setStep(step--)}
                                type="button"
                                className="button is-primary"
                            >
                                Previous
                            </button>
                        </div>
                        <div className="control">
                            <button
                                onClick={() => setStep(step++)}
                                type="button"
                                className="button is-primary"
                            >
                                Next
                            </button>
                        </div>
                    </div>
                </Step>
                <Step show={step === 3}>
                    <h2 className="subtitle is-3 has-text-centered">
                        Account Information
                    </h2>
                    <File
                        label={"Avatar"}
                        name={"avatar"}
                        value={data.avatar}
                        onChange={(e) => setData("avatar", e.target.value)}
                        error={errors.avatar}
                    />
                    <Editor
                        label={"Bio"}
                        name={"bio"}
                        value={data.bio}
                        onChange={async (e) =>
                            setData("bio", await e.saver.save())
                        }
                        error={errors.bio}
                    />
                    <Password
                        label={"Password"}
                        name={"password"}
                        value={data.password}
                        onChange={(e) => setData("password", e.target.value)}
                        error={errors.password}
                    />
                    <ul
                        style="list-style: circle; list-style-position:inside;"
                        className="column is-fullwidth"
                    >
                        <li
                            className={
                                /^(?=.*[0-9])/.test(data.password)
                                    ? "has-text-success"
                                    : "has-text-danger"
                            }
                        >
                            Must contain at least one digit
                        </li>
                        <li
                            className={
                                /^(?=.*[a-z])/.test(data.password)
                                    ? "has-text-success"
                                    : "has-text-danger"
                            }
                        >
                            Must contain at least one lowercase letter
                        </li>
                        <li
                            className={
                                /^(?=.*[A-Z])/.test(data.password)
                                    ? "has-text-success"
                                    : "has-text-danger"
                            }
                        >
                            Must contain at least one uppercase letter
                        </li>
                        <li
                            className={
                                /^(?=.*[@#$%^&-+=()])/.test(data.password)
                                    ? "has-text-success"
                                    : "has-text-danger"
                            }
                        >
                            Must contain at least one symbol (@#$%^&-+=())
                        </li>
                        <li
                            className={
                                /.{12,}/.test(data.password)
                                    ? "has-text-success"
                                    : "has-text-danger"
                            }
                        >
                            Must be at least 12 characters long
                        </li>
                    </ul>

                    <Password
                        label={"Confirm Password"}
                        name={"password_confirmation"}
                        value={data.password_confirmation}
                        onChange={(e) =>
                            setData("password_confirmation", e.target.value)
                        }
                        error={errors.password_confirmation}
                    />
                    <div className="field is-grouped is-grouped-centered">
                        <div className="control">
                            <button
                                onClick={() => setStep(step--)}
                                type="button"
                                className="button is-primary"
                            >
                                Previous
                            </button>
                        </div>
                        <div className="control">
                            <button
                                type="submit"
                                className={`button is-primary ${
                                    processing && "is-loading"
                                }`}
                            >
                                Submit
                            </button>
                        </div>
                    </div>
                </Step>
            </form>
        </Layout>
    );
}
