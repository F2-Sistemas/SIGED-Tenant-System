export const generateRandomString = (length = 5, ofThisChars = null) => {
    const characters = ofThisChars ?? 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    let result = '';
    for (let i = 0; i < length; i++) {
        result += characters.charAt(Math.floor(Math.random() * characters.length));
    }
    return result;
}

export const range = (start, end) => Array.from(Array(end - start + 1).keys()).map(i => i + start);

export const _toString = (data, replacer = null, spacer = 4) => {
    return JSON.stringify(data, replacer, spacer);
};

export const _toArray = (data) => {
    return JSON.parse(JSON.stringify(data));
};
