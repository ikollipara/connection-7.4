/*
|--------------------------------------------------------------------------
| SlimSelect.jsx 
|--------------------------------------------------------------------------
|
| SlimSelect Wrapper Component.
*/

import SlimSelect from "slim-select";
import { useRef } from "react";

export default function SlimSelectComponent({
    options,
    placeholder,
    events,
    ...props
}) {
    const selectRef = useRef(null);

    useEffect(() => {
        new SlimSelect({
            select: selectRef.current,
            placeholder: placeholder,
            events: events,
        });
    }, []);

    return (
        <select {...props} ref={selectRef}>
            {options.map((option) => (
                <option key={option.value} value={option.value}>
                    {option.text}
                </option>
            ))}
        </select>
    );
}
