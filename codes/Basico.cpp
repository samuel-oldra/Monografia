#include <iostream>
#include <stdlib.h>

using namespace std;

int main(){
    
    int integer1 = 0;
    int integer2 = 0;
    int soma = 0;
    
    cout << "Digite o primeiro numero: ";
    cin >> integer1;
    cout << "Digite o segundo  numero: ";
    cin >> integer2;
    soma = integer1 + integer2;
    cout << "A soma de " << integer1 << " + " 
         << integer2 << " = " << soma << endl;
              
    system("Pause");
    return 0;
}
