const Ziggy = {"url":"http:\/\/localhost:8000","port":8000,"defaults":{},"routes":{"index":{"uri":"\/","methods":["GET","HEAD"]},"login":{"uri":"login","methods":["GET","HEAD"]},"logout":{"uri":"logout","methods":["POST"]},"register":{"uri":"register","methods":["GET","HEAD"]},"password.request":{"uri":"password\/reset","methods":["GET","HEAD"]},"password.email":{"uri":"password\/email","methods":["POST"]},"password.reset":{"uri":"password\/reset\/{token}","methods":["GET","HEAD"]},"password.update":{"uri":"password\/reset","methods":["POST"]},"password.confirm":{"uri":"password\/confirm","methods":["GET","HEAD"]},"home":{"uri":"admin","methods":["GET","HEAD"]},"users.index":{"uri":"cms\/users","methods":["GET","HEAD"]},"users.store":{"uri":"cms\/users","methods":["POST"]},"users.show":{"uri":"cms\/users\/{user}","methods":["GET","HEAD"],"bindings":{"user":"id"}},"users.update":{"uri":"cms\/users\/{user}","methods":["PUT","PATCH"],"bindings":{"user":"id"}},"users.destroy":{"uri":"cms\/users\/{user}","methods":["DELETE"],"bindings":{"user":"id"}},"examples.index":{"uri":"cms\/examples","methods":["GET","HEAD"]},"examples.store":{"uri":"cms\/examples","methods":["POST"]},"examples.show":{"uri":"cms\/examples\/{example}","methods":["GET","HEAD"],"bindings":{"example":"id"}},"examples.update":{"uri":"cms\/examples\/{example}","methods":["PUT","PATCH"],"bindings":{"example":"id"}},"examples.destroy":{"uri":"cms\/examples\/{example}","methods":["DELETE"],"bindings":{"example":"id"}},"examples.categories":{"uri":"cms\/example-categories","methods":["GET","HEAD"]}}};

if (typeof window !== 'undefined' && typeof window.Ziggy !== 'undefined') {
    for (let name in window.Ziggy.routes) {
        Ziggy.routes[name] = window.Ziggy.routes[name];
    }
}

export { Ziggy };
